<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	extract($_POST);
	$id = mysqli_real_escape_string($con,$_POST['id']);
	$ket = mysqli_real_escape_string($con,$_POST['ket']);
	$sts= mysqli_real_escape_string($con,$_POST['sts_warna']);
	$acc = mysqli_real_escape_string($con,$_POST['acc']);
	$disposisi = mysqli_real_escape_string($con,$_POST['disposisi']);
				$sqlupdate=mysqli_query($con,"UPDATE `tbl_potongcelup` SET 
				`comment_warna`='$sts',
				`acc`='$acc',
				`disposisi`='$disposisi',
				`ket`='$ket'
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=Potong-Celup';</script>";
				
		}
		

?>
