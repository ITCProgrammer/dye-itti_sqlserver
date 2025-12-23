<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    $pesan = strtoupper($_POST['line_news']);
    
    $sql = "INSERT INTO db_dying.tbl_news_line (gedung, news_line, tgl_update) VALUES (?, ?, GETDATE())";
    $params = array('LT 1', $pesan);
    
    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt) {
        echo "<script>swal({
            title: 'Data Tersimpan',
            text: 'Klik Ok untuk melanjutkan',
            type: 'success',
            }).then((result) => {
            if (result.value) {
                window.location='?p=Line-News';
            }
        });</script>";
    } else {
        echo "<script>swal('Gagal!', 'Gagal menyimpan data news.', 'error');</script>";
    }
}