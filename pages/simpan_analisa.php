<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    $nama = isset($_POST['nama']) ? strtoupper(trim($_POST['nama'])) : '';

    if ($nama !== '') {
        $sql = "INSERT INTO db_dying.tbl_analisa (nama) VALUES (?)";
        $params = [$nama];

        $stmt = sqlsrv_query($con, $sql, $params);

        if ($stmt === false) {
            $err = print_r(sqlsrv_errors(), true);
            die("<pre>Gagal insert ke db_dying.tbl_analisa:\n{$err}</pre>");
        }
    }

    echo "<script>window.location='?p=Form-Celup';</script>";
}
