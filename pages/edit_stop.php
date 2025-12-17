<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    $id 		= $_POST['id'];
    $stop    	= $_POST['tgl_stop']  . " " . $_POST['jam_stop'];
    $stop2   	= $_POST['tgl_stop2'] . " " . $_POST['jam_stop2'];
    $stop3   	= $_POST['tgl_stop3'] . " " . $_POST['jam_stop3'];
    $stop4   	= $_POST['tgl_stop4'] . " " . $_POST['jam_stop4'];
    $mulai   	= $_POST['tgl_mulai']  . " " . $_POST['jam_mulai'];
    $mulai2  	= $_POST['tgl_mulai2'] . " " . $_POST['jam_mulai2'];
    $mulai3  	= $_POST['tgl_mulai3'] . " " . $_POST['jam_mulai3'];
    $mulai4  	= $_POST['tgl_mulai4'] . " " . $_POST['jam_mulai4'];
    $sisa 		= $_POST['sisa_waktu'];
    $qCek 		= sqlsrv_query($con, "SELECT sisa_waktu FROM db_dying.tbl_montemp WHERE id = ?", [$id]);
    $rCek 		= sqlsrv_fetch_array($qCek, SQLSRV_FETCH_ASSOC);
    $lama 		= $rCek['sisa_waktu'];
    $tgl_mulai  = (!empty($_POST['tgl_mulai'])  || !empty($_POST['jam_mulai']))  ? $mulai  : null;
    $tgl_mulai2 = (!empty($_POST['tgl_mulai2']) || !empty($_POST['jam_mulai2'])) ? $mulai2 : null;
    $tgl_mulai3 = (!empty($_POST['tgl_mulai3']) || !empty($_POST['jam_mulai3'])) ? $mulai3 : null;
    $tgl_mulai4 = (!empty($_POST['tgl_mulai4']) || !empty($_POST['jam_mulai4'])) ? $mulai4 : null;
	
    $tgl_stop  = (!empty($_POST['tgl_stop'])  || !empty($_POST['jam_stop']))  ? $stop  : null;
    $tgl_stop2 = (!empty($_POST['tgl_stop2']) || !empty($_POST['jam_stop2'])) ? $stop2 : null;
    $tgl_stop3 = (!empty($_POST['tgl_stop3']) || !empty($_POST['jam_stop3'])) ? $stop3 : null;
    $tgl_stop4 = (!empty($_POST['tgl_stop4']) || !empty($_POST['jam_stop4'])) ? $stop4 : null;

    $sql = "UPDATE db_dying.tbl_montemp SET
				ket_stopmesin  = ?,
				ket_stopmesin2 = ?,
				ket_stopmesin3 = ?,
				ket_stopmesin4 = ?,
				tgl_stop       = ?,
				tgl_stop2      = ?,
				tgl_stop3      = ?,
				tgl_stop4      = ?,
				tgl_mulai      = ?,
				tgl_mulai2     = ?,
				tgl_mulai3     = ?,
				tgl_mulai4     = ?,
				sisa_waktu     = ?
			WHERE id = ?
    ";
    $params = [
        $_POST['ket_stopmesin'],
        $_POST['ket_stopmesin2'],
        $_POST['ket_stopmesin3'],
        $_POST['ket_stopmesin4'],
        $tgl_stop ,
        $tgl_stop2,
        $tgl_stop3,
        $tgl_stop4,
        $tgl_mulai,
        $tgl_mulai2,
        $tgl_mulai3,
        $tgl_mulai4,
        $sisa,
        $id
    ];
	// print_r($params);
    $sqlupdate = sqlsrv_query($con, $sql, $params);

    if ($sqlupdate) {
        echo "<script>
                swal({
                    title: 'Data telah terupdate',
                    text: 'Klik Ok untuk kembali',
                    type: 'success',
                }).then((result) => {
                    if (result.value) {
                        window.location.href='?p=Monitoring-Tempelan';
                    }
                });
              </script>";
    } else {
        $err = json_encode(sqlsrv_errors(), JSON_PRETTY_PRINT);
        echo "<script>
                swal({
                    title: 'Gagal Update!',
                    text: `Error SQL Server:\\n$err`,
                    type: 'error',
                }).then((result) => {
                    if (result.value) {
                        window.location.href='?p=Monitoring-Tempelan';
                    }
                });
              </script>";
    }
}
?>
