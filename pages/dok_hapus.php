<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];	
    $modal1=mysqli_query($con,"DELETE FROM tbl_dokumen WHERE id='$modal_id' ");
    if ($modal1) {
		echo "<script>window.location='?p=Input-Dokumen';</script>";
    } else {
        echo "<script>window.location='?p=Input-Dokumen';</script>";
    }
