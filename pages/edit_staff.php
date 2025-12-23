<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	$id = $_POST['id'];
	$nama = strtoupper($_POST['nama']); 
	$jab = $_POST['jabatan']; 

	$sql = "UPDATE db_dying.tbl_staff SET nama = ?, jabatan = ? WHERE id = ?";
	$params = array($nama, $jab, $id);
	$stmt = sqlsrv_query($con, $sql, $params);

	if ($stmt) {
		echo "<script>
				swal({
					title: 'Berhasil!',
					text: 'Data staff berhasil diperbarui.',
					type: 'success'
				}).then(function() {
					window.location = '?p=Staff';
				});
			  </script>";
	} else {
		echo "<script>swal('Gagal!', 'Gagal memperbarui data staff.', 'error');</script>";
	}
}

?>
