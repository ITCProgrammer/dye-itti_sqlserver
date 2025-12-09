<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    extract($_POST);
    $nama = mysqli_real_escape_string($con,strtoupper($_POST['nama']));
    $jab = mysqli_real_escape_string($con,$_POST['jabatan']);    
        $sqlupdate=mysqli_query($con,"INSERT INTO `tbl_staff` SET
				`nama`='$nama',				
				`jabatan`='$jab'
				");
        echo " <script>window.location='?p=Staff';</script>";
    }