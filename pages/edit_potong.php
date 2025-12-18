<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");

if ($_POST) {
	// Ambil nilai dari POST (trim untuk rapikan)
	$id        = isset($_POST['id']) ? $_POST['id'] : '';
	$ket       = isset($_POST['ket']) ? $_POST['ket'] : '';
	$sts       = isset($_POST['sts_warna']) ? $_POST['sts_warna'] : '';
	$acc       = isset($_POST['acc']) ? $_POST['acc'] : '';
	$disposisi = isset($_POST['disposisi']) ? $_POST['disposisi'] : '';

	// Update ke SQL Server dengan parameter
	$sql  = "UPDATE db_dying.tbl_potongcelup
	         SET comment_warna = ?, acc = ?, disposisi = ?, ket = ?
	         WHERE id = ?";
	$params = [$sts, $acc, $disposisi, $ket, $id];

	$stmt = sqlsrv_query($con, $sql, $params);
	if ($stmt === false) {
		$err = print_r(sqlsrv_errors(), true);
		die("<pre>Gagal update tbl_potongcelup:\n{$err}</pre>");
	}

	echo "<script>window.location='?p=Potong-Celup';</script>";
}

?>
