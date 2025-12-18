<?php
// hapus-celup.php
include '../koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Validasi: pastikan ID adalah integer (jika memang ID numeric)
    if (!is_numeric($id) || (string)(int)$id !== (string)$id) {
        http_response_code(400);
        echo 'ID tidak valid.';
        exit;
    }

    // Gunakan parameterized query (prepared statement ala SQL Server)
    $sql = "DELETE FROM db_dying.tbl_status_proses WHERE id = ?";
    $params = [(int)$id]; // pastikan tipe data sesuai

    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt === false) {
        // Error saat eksekusi
        http_response_code(500);
        echo 'Gagal menghapus data.';
        // Opsional: log error
        // error_log(print_r(sqlsrv_errors(), true));
    } else {
        // Cek apakah ada baris yang dihapus
        $rowsAffected = sqlsrv_rows_affected($stmt);
        if ($rowsAffected === false) {
            http_response_code(500);
            echo 'Error memeriksa hasil penghapusan.';
        } elseif ($rowsAffected == 0) {
            http_response_code(404);
            echo 'Data tidak ditemukan.';
        } else {
            echo 'success';
        }
    }

    if ($stmt) {
        sqlsrv_free_stmt($stmt);
    }

} else {
    http_response_code(400);
    echo 'ID tidak ditemukan.';
}
?>