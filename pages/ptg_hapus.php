<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal1=mysqli_query($con,"DELETE FROM tbl_potongcelup WHERE id='$modal_id' ");
    if ($modal1) {
		echo "<script>window.location='?p=Potong-Celup';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Potong-Celup';</script>";
    }
