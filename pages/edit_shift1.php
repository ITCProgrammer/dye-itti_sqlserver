<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	extract($_POST);
	$id 	= isset($_POST['id']) ? $_POST['id'] : '';
	$shift 	= isset($_POST['shift']) ? $_POST['shift'] : '';
	$gshift = isset($_POST['gshift']) ? $_POST['gshift'] : '';
				$sqlupdate=sqlsrv_query($con,"UPDATE db_dying.tbl_hasilcelup SET 
				g_shift='$gshift',
				shift='$shift'
				WHERE id='$id'");
				$sqlupdate1=sqlsrv_query($con,"UPDATE db_dying.tbl_potongcelup SET 
				`g_shift`='$gshift',
				`shift`='$shift'
				WHERE `id_hasilcelup`='$id'");
				echo " <script>window.location='?p=Hasil-Celup';</script>";
						
		}
		

?>
