<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
    $modal=sqlsrv_query($con,"DELETE FROM db_dying.tbl_datatest WHERE id='$modal_id' ");
    if ($modal) {
        echo "<script>Swal.fire('Sukses!', 'Data berhasil dihapus.', 'success').then(function() { window.location='index1.php?p=Lap-DataTest-Proses'; });</script>";
    } else {
        echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error').then(function() { window.location='index1.php?p=Lap-DataTest-Proses'; });</script>";
    }
