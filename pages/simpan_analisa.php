<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    extract($_POST);
    $nama = mysqli_real_escape_string($con,$_POST['nama']);
	$nama = strtoupper($nama);
        $sqlupdate=mysqli_query($con,"INSERT INTO `tbl_analisa` SET
				`nama`='$nama'
				");
        echo " <script>window.location='?p=Form-Celup';</script>";
    }