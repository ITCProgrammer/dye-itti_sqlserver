<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$cek=mysqli_query($con,"SELECT id_schedule FROM tbl_montemp WHERE id='$modal_id' ");
	$r=mysqli_fetch_array($cek);
	$cek1=mysqli_query($con,"SELECT no_mesin FROM tbl_schedule WHERE id='$r[id_schedule]' ");
	$r1=mysqli_fetch_array($cek1);
    $modal1=mysqli_query($con,"DELETE FROM tbl_montemp WHERE id='$modal_id' ");
    if ($modal1) {
		$qSCH=mysqli_query($con,"UPDATE tbl_schedule SET `status`='antri mesin' WHERE id='$r[id_schedule]' ");
		$qSCH1=mysqli_query($con,"UPDATE tbl_schedule SET `status`='antri mesin' WHERE no_mesin='$r1[no_mesin]' AND `status`='sedang jalan' ");
        echo "<script>window.location='?p=Monitoring-Tempelan';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Monitoring-Tempelan';</script>";
    }
