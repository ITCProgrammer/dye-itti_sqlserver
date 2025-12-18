<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$modal_id = isset($_GET['id']) ? $_GET['id'] : '';

// Ambil data hasilcelup
$cek = sqlsrv_query(
    $con,
    "SELECT * FROM db_dying.tbl_hasilcelup WHERE id = ?",
    [$modal_id]
);
$r = sqlsrv_fetch_array($cek, SQLSRV_FETCH_ASSOC);

if ($r) {
    // Ambil data montemp
    $cek1 = sqlsrv_query(
        $con,
        "SELECT * FROM db_dying.tbl_montemp WHERE id = ?",
        [$r['id_montemp']]
    );
    $r1 = sqlsrv_fetch_array($cek1, SQLSRV_FETCH_ASSOC);

    // Ambil schedule terkait
    $qCek = sqlsrv_query(
        $con,
        "SELECT TOP 1 * FROM db_dying.tbl_schedule WHERE id = ?",
        [$r1['id_schedule']]
    );
    $rCek = sqlsrv_fetch_array($qCek, SQLSRV_FETCH_ASSOC);

    // Mulai transaksi
    sqlsrv_begin_transaction($con);

    $ok = true;

    // Hapus hasilcelup
    $modal1 = sqlsrv_query(
        $con,
        "DELETE FROM db_dying.tbl_hasilcelup WHERE id = ?",
        [$modal_id]
    );
    if ($modal1 === false) $ok = false;

    // Update schedule & montemp kembali 'sedang jalan'
    if ($ok) {
        $qSCH = sqlsrv_query(
            $con,
            "UPDATE db_dying.tbl_schedule SET status = 'sedang jalan' WHERE id = ?",
            [$r1['id_schedule']]
        );
        if ($qSCH === false) $ok = false;
    }

    if ($ok) {
        $qMTP = sqlsrv_query(
            $con,
            "UPDATE db_dying.tbl_montemp SET status = 'sedang jalan' WHERE id = ?",
            [$r['id_montemp']]
        );
        if ($qMTP === false) $ok = false;
    }

    // Geser no_urut antri mesin di mesin yang sama
    if ($ok) {
        $qUrut = sqlsrv_query(
            $con,
            "UPDATE db_dying.tbl_schedule
             SET no_urut = no_urut + 1
             WHERE no_mesin = ?
               AND status = 'antri mesin'",
            [$rCek['no_mesin']]
        );
        if ($qUrut === false) $ok = false;
    }

    if ($ok) {
        sqlsrv_commit($con);
        echo "<script>window.location='?p=Hasil-Celup';</script>";
    } else {
        sqlsrv_rollback($con);
        echo "<script>alert('Gagal Hapus');window.location='?p=Hasil-Celup';</script>";
    }
} else {
    echo "<script>alert('Data tidak ditemukan');window.location='?p=Hasil-Celup';</script>";
}
