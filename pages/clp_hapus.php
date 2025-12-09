<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$cek=mysqli_query($con,"SELECT * FROM tbl_hasilcelup WHERE id='$modal_id' ");
	$r=mysqli_fetch_array($cek);
    $cek1=mysqli_query($con,"SELECT * FROM tbl_montemp WHERE id='$r[id_montemp]' ");
	$r1=mysqli_fetch_array($cek1);
	$qCek=mysqli_query($con,"SELECT * FROM tbl_schedule WHERE id='$r1[id_schedule]' LIMIT 1");
	$rCek=mysqli_fetch_array($qCek);
    $modal1=mysqli_query($con,"DELETE FROM tbl_hasilcelup WHERE id='$modal_id' ");
    if ($modal1) {
		$qSCH=mysqli_query($con,"UPDATE tbl_schedule SET status='sedang jalan' WHERE id='$r1[id_schedule]' ");
		$qMTP=mysqli_query($con,"UPDATE tbl_montemp SET status='sedang jalan' WHERE id='$r[id_montemp]' ");
		$qMTP=mysqli_query($con,"UPDATE tbl_schedule 
		  SET no_urut = no_urut + 1 
		  WHERE no_mesin = '$rCek[no_mesin]' 
		  AND `status` = 'antri mesin' ");
        echo "<script>window.location='?p=Hasil-Celup';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Hasil-Celup';</script>";
    }
