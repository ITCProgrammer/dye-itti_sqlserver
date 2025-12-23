<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
    
    $sql = "DELETE FROM db_dying.tbl_news_line WHERE id = ?";
    $params = array($modal_id);
    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt) {
        echo "<script>swal({
            title: 'Berhasil!',
            text: 'Data berhasil dihapus.',
            type: 'success'
        }).then(function() {
            window.location = '?p=Line-News';
        });</script>";
    } else {
        echo "<script>swal('Gagal!', 'Gagal menghapus data.', 'error');</script>";
    }
