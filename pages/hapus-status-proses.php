<?php
// hapus-celup.php
include '../koneksi.php';
if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $query = mysqli_query($con, "DELETE FROM tbl_status_proses WHERE id='$id'");
    if ($query) {
        echo 'success';
    } else {
        http_response_code(500);
        echo 'Gagal menghapus data.';
    }
} else {
    http_response_code(400);
    echo 'ID tidak ditemukan.';
}
?>

