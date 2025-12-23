<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$user = $_POST['username'];
	$pass = $_POST['password'];   
    $repass = $_POST['re_password']; 
    $level = $_POST['level'];
    $status = $_POST['status'];

	if($pass != $repass) {
		echo "<script>swal('Gagal!', 'Password dan Re-Password tidak cocok!', 'warning').then(function() { window.history.back(); });</script>";
	} else {
		$sql = "UPDATE db_dying.tbl_user SET 
				nama = ?,
				username = ?, 
				password = ?,
				level = ?,
				status = ?,
				tgl_update = GETDATE()
				WHERE id = ?";
		
		$params = array($nama, $user, $pass, $level, $status, $id);
		$stmt = sqlsrv_query($con, $sql, $params);

		if ($stmt) {
			echo "<script>
					swal({
						title: 'Berhasil!',
						text: 'Data user berhasil diperbarui.',
						type: 'success'
					}).then(function() {
						window.location = '?p=User';
					});
				  </script>";
		} else {
			echo "<script>swal('Gagal!', 'Gagal memperbarui data user.', 'error');</script>";
		}
	}
}

?>
