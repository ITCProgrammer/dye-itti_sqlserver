<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
    $modal1=mysqli_query($con,"DELETE FROM tbl_schedule WHERE id='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=Schedule';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Schedule';</script>";
    }
