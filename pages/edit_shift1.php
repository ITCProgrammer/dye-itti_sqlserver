<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	extract($_POST);
	$id 	= mysqli_real_escape_string($con,$_POST['id']);
	$shift 	= mysqli_real_escape_string($con,$_POST['shift']);
	$gshift = mysqli_real_escape_string($con,$_POST['gshift']); 
				$sqlupdate=mysqli_query($con,"UPDATE `tbl_hasilcelup` SET 
				`g_shift`='$gshift',
				`shift`='$shift'
				WHERE `id`='$id' LIMIT 1");
				$sqlupdate1=mysqli_query($con,"UPDATE `tbl_potongcelup` SET 
				`g_shift`='$gshift',
				`shift`='$shift'
				WHERE `id_hasilcelup`='$id' LIMIT 1");
				echo " <script>window.location='?p=Hasil-Celup';</script>";
						
		}
		

?>
