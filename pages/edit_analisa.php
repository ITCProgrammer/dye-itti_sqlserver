<?php
ini_set("error_reporting", 1);
$cond=mysqli_connect("10.0.1.91","dit","4dm1n","db_qc");
if($_POST){ 
	extract($_POST);
	$id = mysqli_real_escape_string($con,$_POST['id']);
	$awal= $_POST['awal'];
	$akhir=$_POST['akhir'];
	$analisa = mysqli_real_escape_string($con,$_POST['analisa_penyebab']);	
				$sqlupdate=mysqli_query($con,"UPDATE `tbl_ncp_qcf` SET 
				`analisa_penyebab`='$analisa'
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=Lap-NCP&awal=$awal&akhir=$akhir';</script>";
				//echo " <script>window.location.reload(window.history.go(-1));</script>";
				
		}
		

?>
