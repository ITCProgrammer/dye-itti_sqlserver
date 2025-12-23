<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	extract($_POST);
	$id			= str_replace("'", "''",$_POST['id']);
	$kap		= str_replace("'", "''",$_POST['kap']); 
	$l_r		= str_replace("'", "''",$_POST['l_r']);
	$kd			= str_replace("'", "''",$_POST['kode']);
	$nomesin	= str_replace("'", "''",$_POST['no_mesin']);
	$note 		= str_replace("'", "''",$_POST['note']); 

	$sqlupdate = "UPDATE db_dying.tbl_mesin SET 
					kapasitas = ?, 
					l_r = ?,
					kode = ?,
					ket = ?,
					no_mesin = ?
				  WHERE id = ?";
	
	$params = array($kap, $l_r, $kd, $note, $nomesin, $id);
	$stmt = sqlsrv_query($con, $sqlupdate, $params);

	if ($stmt) {
		echo "<script>
				swal({
					title: 'Berhasil!',
					text: 'Data mesin berhasil diperbarui.',
					type: 'success'
				}).then(function() {
					window.location = '?p=Mesin';
				});
			  </script>";
	} else {
		echo "<script>swal('Gagal!', 'Gagal memperbarui data. Silakan coba lagi.', 'error');</script>";
	}
}

?>
