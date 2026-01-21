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

    $sql = "INSERT INTO db_dying.log_monitoring (log, tgl_log, [user], [query]) VALUES (?, GETDATE(), ?, ?)";
    $params = [$message, $user, $queryLengkap];
    $result = sqlsrv_query($con, $sql, $params);

    return $result !== false;
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
