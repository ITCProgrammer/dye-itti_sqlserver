<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");

// Proses ubah urutan & personil
if (isset($_POST['ubah'])) { 
    extract($_POST);
    $urut       = $_POST['no_urut'];
    $personil   = $_POST['personil'];
    $user_id    = $_SESSION['nama10']; 
    $getdate    = date('Y-m-d H:i:s'); 
    $remote_add = $_SERVER['REMOTE_ADDR']; 

    foreach ($urut as $urut_key => $urut_value) {
        // Ambil data urutan lama dari database (SQL Server)
        $q_old = sqlsrv_query($con, "SELECT * FROM db_dying.tbl_schedule WHERE id = ?", array($urut_key));
        if ($q_old === false) {
            die('Gagal ambil data lama: ' . print_r(sqlsrv_errors(), true));
        }

        $d_old = sqlsrv_fetch_array($q_old, SQLSRV_FETCH_ASSOC);
        if ($d_old === null) {
            // Jika data dengan id tsb tidak ditemukan, lewati saja
            continue;
        }

        $no_urut_lama = $d_old['no_urut'];

        // Cek jika urutan berubah baru lakukan update
        if ($urut_value != $no_urut_lama) {
            $nama_personil = $personil[$urut_key];

            $query  = "UPDATE db_dying.tbl_schedule 
                       SET no_urut = ?, 
                           personil = ? 
                       WHERE id = ?;";
            $params = array($urut_value, $nama_personil, $urut_key);
            $result = sqlsrv_query($con, $query, $params);

            if ($result === false) {
                die('Gagal update: ' . print_r(sqlsrv_errors(), true));
            }
            else
            {
                $query_log = "INSERT INTO db_dying.tbl_log_mc_schedule 
                                    (id_schedule, nodemand, nokk,no_mc,no_urut,no_sch,user_update,date_update,ip_update,col_update) 
                             VALUES (?,?,?,?,?,?,?,?,?,'UPDATE_NO_URUT')";
                $params_log = [$urut_key,$d_old['nodemand'],$d_old['nokk'],$d_old['no_mesin'], 
                            $urut_value, $d_old['no_sch'], $user_id,$getdate,$remote_add];
                $sqlLog = sqlsrv_query($con, $query_log, $params_log);
                // echo " <script>window.location='?p=Schedule';</script>";
            }
        }
    }

    echo " <script>window.location='?p=Schedule';</script>";

// Proses ubah std target
} elseif (isset($_POST['ubah_stdtarget'])) {
    extract($_POST);
    $urut             = $_POST['no_urut'];
    $personil         = $_POST['personil'];
    $creationdatetime = date('Y-m-d H:i:s');
    $user_id            = $_SESSION['nama10']; 
    $getdate            = date('Y-m-d H:i:s'); 
    $remote_add         = $_SERVER['REMOTE_ADDR'];

    foreach ($urut as $urut_key => $urut_value) {
        // Normalisasi nilai target agar sesuai dengan kolom decimal(5,2)
        $target_input = isset($_POST['target'][$urut_key]) ? trim($_POST['target'][$urut_key]) : null;
        if ($target_input === '' || $target_input === null) {
            $target = null;
        } else {
            // Ganti koma menjadi titik (contoh: "1,25" -> "1.25")
            $normalized = str_replace(',', '.', $target_input);
            if (!is_numeric($normalized)) {
                die('cant update: nilai target tidak valid: ' . htmlspecialchars($target_input));
            }
            // Konversi ke float agar driver SQL Server mengirim sebagai numeric
            $target = (float)$normalized;
            // Kolom target bertipe DECIMAL(4,2) -> range -99.99 s/d 99.99
            if ($target > 99.99 || $target < -99.99) {
                die('cant update: nilai target di luar range (maksimal 99.99) : ' . htmlspecialchars($target_input));
            }
        }

        $nama_personil = $personil[$urut_key];
        $q_old = sqlsrv_query($con, "SELECT * FROM db_dying.tbl_schedule WHERE id = ?", array($urut_key));
        $d_old = sqlsrv_fetch_array($q_old, SQLSRV_FETCH_ASSOC);
        // Pada ubah_stdtarget juga boleh mengubah no_urut
        $query  = "UPDATE db_dying.tbl_schedule 
                   SET target = ?, 
                       personil_stdtarget = ?, 
                       lastupdatetime_stdtarget = ?, 
                       no_urut = ? 
                   WHERE id = ?;";
        $params = array($target, $nama_personil, $creationdatetime, $urut_value, $urut_key);
        $result = sqlsrv_query($con, $query, $params);

        if ($result === false) {
            die('cant update: ' . print_r(sqlsrv_errors(), true));
        }else{
                $query_log = "INSERT INTO db_dying.tbl_log_mc_schedule 
                                    (id_schedule, nodemand, nokk,no_mc,no_urut,no_sch,user_update,date_update,ip_update,col_update) 
                             VALUES (?,?,?,?,?,?,?,?,?,'UPDATE_STD_TARGET')";
                $params_log = [$urut_key,$d_old['nodemand'],$d_old['nokk'],$d_old['no_mesin'], 
                            $urut_value, $d_old['no_sch'], $user_id,$getdate,$remote_add];
                $sqlLog = sqlsrv_query($con, $query_log, $params_log);
        // echo " <script>window.location='?p=Schedule';</script>";
    }

    }

    echo " <script>window.location='?p=Schedule';</script>";
}
?>
