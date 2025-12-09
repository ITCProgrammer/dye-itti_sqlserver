<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    extract($_POST);
    $kode = mysqli_real_escape_string($con,strtoupper($_POST['kode']));
    $jns = mysqli_real_escape_string($con,$_POST['jenis']);
	$target = mysqli_real_escape_string($con,$_POST['target']); 
        $sqlupdate=mysqli_query($con,"INSERT INTO `tbl_std_jam` SET
				`kode`='$kode',				
				`jenis`='$jns',
				`target`='$target'
				");
        echo " <script>window.location='?p=Std-Target';</script>";
    }