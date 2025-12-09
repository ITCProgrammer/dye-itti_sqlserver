<?php
ini_set("error_reporting", 1);
$cond=mysqli_connect("10.0.0.10","dit","4dm1n","db_dying");
if($_POST){ 
	extract($_POST);
	$id = mysqli_real_escape_string($cond,$_POST['id']);
	$awal= $_POST['awal'];
	$akhir=$_POST['akhir'];
	$analisa = mysqli_real_escape_string($cond,$_POST['analisa_penyebab']);	
				$sqlupdate=mysqli_query($cond,"UPDATE `tbl_ncp_memo` SET 
				`analisa_penyebab`='$analisa'
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=Lap-NCPMemo&awal=$awal&akhir=$akhir';</script>";
				//echo " <script>window.location.reload(window.history.go(-1));</script>";
				
		}
		

?>
