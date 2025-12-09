<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
function cekDesimal($angka){
	$bulat=round($angka);
	if($bulat>$angka){
		$jam=$bulat-1;
		$waktu=$jam.":30";
	}else{
		$jam=$bulat;
		$waktu=$jam.":00";
	}
	return $waktu;
}
if($_POST){ 
	extract($_POST);
	$id = mysqli_real_escape_string($con,$_POST['id']);
	$urut = mysqli_real_escape_string($con,$_POST['no_urut']);
	$ketkain = mysqli_real_escape_string($con,$_POST['ket_kain']);
	$ket = mysqli_real_escape_string($con,$_POST['ket']);
	$personil = mysqli_real_escape_string($con,$_POST['personil']);
	$mesin = mysqli_real_escape_string($con,$_POST['no_mesin']);
	$mcfrom = mysqli_real_escape_string($con,$_POST['mc_from']);
	$proses = mysqli_real_escape_string($con,$_POST['proses']);
	$target = mysqli_real_escape_string($con,$_POST['target']);
	$resep=  mysqli_real_escape_string($con,$_POST['no_resep']);
	$resep2=  mysqli_real_escape_string($con,$_POST['no_resep2']);
	$target1=cekDesimal($target);
	$status = mysqli_real_escape_string($con,$_POST['status']);
	if($status!=""){ $sts=", `status`='$status' ";}else{ $sts="";}
	if($_POST['kk_kestabilan']=="1"){$kk_kestabilan="1";}else{ $kk_kestabilan="0";}
	if($_POST['kk_normal']=="1"){$kk_normal="1";}else{ $kk_normal="0";}
	$Qrycek=mysqli_query($con,"SELECT * FROM tbl_mesin WHERE no_mesin='$mesin' LIMIT 1");
	$rCek=mysqli_fetch_array($Qrycek);
	$kapasitas=$rCek['kapasitas'];
				$sqlupdate=mysqli_query($con,"UPDATE `tbl_schedule` SET 
				`no_mesin`='$mesin',
				`kapasitas`='$kapasitas',
				`mc_from`='$mcfrom',
				`target`='$target',
				`proses`='$proses',
				`no_urut`='$urut',
				`no_sch`='$urut',
				`no_resep`='$resep',
				`no_resep2`='$resep2',
				`ket_kain`='$ketkain',
				`ket_status`='$ket',
				`kk_kestabilan`='$kk_kestabilan',
		 	 	`kk_normal`='$kk_normal',
				`personil`='$personil'
				$sts
				WHERE `id`='$id' LIMIT 1");
				$sqlupdate1=mysqli_query($con,"UPDATE tbl_montemp SET 
				tgl_target= ADDDATE(tgl_buat, INTERVAL '$target1' HOUR_MINUTE) 
				WHERE id_schedule='$id' LIMIT 1");
				echo " <script>window.location='?p=Schedule';</script>";
				
		}
		

?>
