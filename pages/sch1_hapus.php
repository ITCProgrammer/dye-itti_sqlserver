<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
    $modal1=mysqli_query($con,"UPDATE tbl_schedule SET `status`='selesai' WHERE id='$modal_id' ");
	$modal1=mysqli_query($con,"UPDATE tbl_montemp SET `status`='selesai' WHERE id_schedule='$modal_id'");
    if ($modal1) {
        echo "<script>window.location='?p=Schedule-Cek';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Schedule-Cek';</script>";
    }
