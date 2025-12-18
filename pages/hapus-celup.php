<?php
// hapus-celup.php
include '../koneksi.php';
if (isset($_POST['id'])) {
    $id = trim($_POST['id']);

    if ($id !== '') {
        $sql = "DELETE FROM db_dying.tbl_analisa WHERE id = ?";
        $params = [$id];

        $stmt = sqlsrv_query($con, $sql, $params);

        if ($stmt !== false) {
            echo 'success';
        } else {
            http_response_code(500);
            echo 'Gagal menghapus data.';
        }
    } else {
        http_response_code(400);
        echo 'ID tidak valid.';
    }
} else {
    http_response_code(400);
    echo 'ID tidak ditemukan.';
}
?>
