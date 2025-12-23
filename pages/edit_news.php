<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    $id = $_POST['id'];
    $line = strtoupper($_POST['line_news']);
    $sts = $_POST['sts'];

    $sql = "UPDATE db_dying.tbl_news_line SET news_line = ?, status = ?, tgl_update = GETDATE() WHERE id = ?";
    $params = array($line, $sts, $id);
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
        echo "<script>swal('Gagal!', 'Gagal memperbarui data news.', 'error');</script>";
    }
}
