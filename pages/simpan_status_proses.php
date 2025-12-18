<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");

if ($_POST) {
    // Ambil dan normalisasi input
    $nama = isset($_POST['nama']) ? strtoupper(trim($_POST['nama'])) : '';

    if ($nama !== '') {
        // Gunakan parameterized query ke SQL Server
        $sql  = "INSERT INTO db_dying.tbl_status_proses (nama) VALUES (?)";
        $params = [$nama];

        $stmt = sqlsrv_query($con, $sql, $params);

        if ($stmt === false) {
            $err = print_r(sqlsrv_errors(), true);
            die("<pre>Gagal insert ke db_dying.tbl_status_proses:\n{$err}</pre>");
        }
    }

    echo "<script>window.location='?p=Form-Celup';</script>";
}
