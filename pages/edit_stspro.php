<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	extract($_POST);
	$id 	= mysqli_real_escape_string($con,$_POST['id']);
	$sts 	= mysqli_real_escape_string($con,$_POST['sts']); 
				$sqlupdate=mysqli_query($con,"UPDATE `tbl_hasilcelup` SET 
				`status`='$sts'
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=lap-harian-produksi';</script>";
						
		}
		

?>
