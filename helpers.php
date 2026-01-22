<?php

function formatDateTime($date, $format = "Y-m-d H:i:s")
{
    if ($date === null || $date === "" ) {
        return null;
    }

    if ($date instanceof DateTime) {
        return $date->format($format);
    }

    try {
        $dt = new DateTime($date);
        return $dt->format($format);
    } catch (Exception $e) {
        return null;
    }
}


function escapeString($str)
{
    if ($str === null) {
        return null;
    }

    $str = trim($str);
    $str = str_replace("'", "''", $str);
    $str = preg_replace('/[^\PC\s]/u', '', $str);

    return $str;
}

function num($v) {
    if ($v === "" || $v === null) return null;
    return preg_replace('/[^0-9.\-]/', '', $v);
}

function toNumericOrNull($value) {
    // trim spaces
    $value = trim($value);

    // jika kosong → NULL
    if ($value === "" || $value === null) {
        return NULL;
    }

    // jika mengandung karakter selain angka, minus, titik → invalid → NULL
    if (!preg_match('/^-?[0-9]+(\.[0-9]+)?$/', $value)) {
        return NULL;
    }

    // jika valid numeric → kembalikan dalam bentuk numeric
    return $value; // convert otomatis ke int/float
}

function getNumericVal($val) {
    $val = isset($val) ? trim($val) : '';

    if ($val === '' || !is_numeric($val)) {
        return null; 
    }

    return $val;
}

function normalizeNumber($value)
{
    if ($value === null) {
        return null;
    }

    $value = trim((string)$value);
    if ($value === '') {
        return null;
    }

    $lastDot = strrpos($value, '.');
    $lastComma = strrpos($value, ',');
    if ($lastComma !== false && ($lastDot === false || $lastComma > $lastDot)) {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
    } else {
        $value = str_replace(',', '', $value);
    }

    $value = preg_replace('/[^0-9.\-]/', '', $value);
    if ($value === '' || !is_numeric($value)) {
        return null;
    }

    return (float)$value;
}

function normalizeInt($value)
{
    $num = normalizeNumber($value);
    if ($num === null) {
        return null;
    }

    return (int)round($num);
}

function normalizeDecimal($value, $scale = 2)
{
    $num = normalizeNumber($value);
    if ($num === null) {
        return null;
    }

    return round($num, $scale);
}

function clampDecimal($value, $max)
{
    if ($value === null) {
        return null;
    }

    if ($value > $max) {
        return $max;
    }
    if ($value < -$max) {
        return -$max;
    }

    return $value;
}

function sqlsrvErrorMessage($errors = null)
{
    if ($errors === null) {
        $errors = sqlsrv_errors();
    }

    if ($errors === null) {
        return "Unknown SQL Server error.";
    }

    $msg = "";
    foreach ($errors as $err) {
        $msg .= "SQLSTATE: " . $err['SQLSTATE'] . "\n";
        $msg .= "Kode: " . $err['code'] . "\n";
        $msg .= "Pesan: " . $err['message'] . "\n\n";
    }

    return $msg;
}

function logMonitoringError($con, $message, $user = null, $queryLengkap = null)
{
    if ($user === null && isset($_SESSION['user_id10'])) {
        $user = $_SESSION['user_id10'];
    }

    $identityCheck = sqlsrv_query(
        $con,
        "SELECT COLUMNPROPERTY(OBJECT_ID('db_dying.log_monitoring'), 'id', 'IsIdentity') AS is_identity"
    );
    if ($identityCheck === false) {
        return false;
    }

    $identityRow = sqlsrv_fetch_array($identityCheck, SQLSRV_FETCH_ASSOC);
    $isIdentity = !empty($identityRow['is_identity']);

    if ($isIdentity) {
        $sql = "INSERT INTO db_dying.log_monitoring ([log], tgl_log, [user], [query]) VALUES (?, GETDATE(), ?, ?)";
        $params = [$message, $user, $queryLengkap];
        $result = sqlsrv_query($con, $sql, $params);

        return $result !== false;
    }

    if (!sqlsrv_begin_transaction($con)) {
        return false;
    }

    $nextIdStmt = sqlsrv_query(
        $con,
        "SELECT ISNULL(MAX(id), 0) + 1 AS next_id FROM db_dying.log_monitoring WITH (UPDLOCK, HOLDLOCK)"
    );
    if ($nextIdStmt === false) {
        sqlsrv_rollback($con);
        return false;
    }

    $nextIdRow = sqlsrv_fetch_array($nextIdStmt, SQLSRV_FETCH_ASSOC);
    $nextId = $nextIdRow ? $nextIdRow['next_id'] : null;
    if ($nextId === null) {
        sqlsrv_rollback($con);
        return false;
    }

    $sql = "INSERT INTO db_dying.log_monitoring (id, [log], tgl_log, [user], [query]) VALUES (?, ?, GETDATE(), ?, ?)";
    $params = [$nextId, $message, $user, $queryLengkap];
    $result = sqlsrv_query($con, $sql, $params);
    if ($result === false) {
        sqlsrv_rollback($con);
        return false;
    }

    sqlsrv_commit($con);
    return true;
}

function sqlsrvLogAndAlert($con, $context = null, $user = null, $errors = null, $title = "Error SQL Server!", $queryLengkap = null)
{
    $msg = sqlsrvErrorMessage($errors);
    $full = $context ? $context . "\n\n" . $msg : $msg;
    logMonitoringError($con, $full, $user, $queryLengkap);

    $msgEscaped = addslashes($msg);
    $titleEscaped = addslashes($title);

    return "
    <script>
        swal({
            title: '" . $titleEscaped . "',
            text: `" . $msgEscaped . "`,
            icon: 'error',
        });
    </script>";
}
