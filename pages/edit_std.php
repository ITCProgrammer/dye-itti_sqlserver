<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	$id = $_POST['id'];
	$jenis = strtoupper($_POST['jenis']); 
	$target = $_POST['target']; 

	$sql = "UPDATE db_dying.tbl_std_jam SET 
			jenis = ?, 
			target = ?
			WHERE id = ?";
	
	$params = array($jenis, $target, $id);
	$stmt = sqlsrv_query($con, $sql, $params);

	if ($stmt) {
		echo "<script>
				swal({
					title: 'Berhasil!',
					text: 'Data standard target berhasil diperbarui.',
					type: 'success'
				}).then(function() {
					window.location = '?p=Std-Target';
				});
			  </script>";
	} else {
		echo "<script>swal('Gagal!', 'Gagal memperbarui data. Silakan coba lagi.', 'error');</script>";
	}
}

?>
