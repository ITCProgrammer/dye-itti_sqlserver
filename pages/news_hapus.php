<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal1=mysqli_query($con,"DELETE FROM tbl_news_line WHERE id='$modal_id' ");
    if ($modal1) {
		echo "<script>window.location='?p=Line-News';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Line-News';</script>";
    }
