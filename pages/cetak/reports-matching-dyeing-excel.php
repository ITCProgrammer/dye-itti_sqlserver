<?php
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename= Report Matching Dyeing.xls"); //ganti nama sesuai keperluan
    header("Pragma: no-cache");
    header("Expires: 0");
    //disini script laporan anda
?>
<?PHP
	ini_set("error_reporting", 1);
	session_start();
    include "../../koneksi.php";
    $Awal   = isset($_GET['awal']) ? $_GET['awal'] : '';
    $Akhir  = isset($_GET['akhir']) ? $_GET['akhir'] : '';
    $jamA   = isset($_GET['jam_awal']) ? $_GET['jam_awal'] : '';
    $jamAr  = isset($_GET['jam_akhir']) ? $_GET['jam_akhir'] : '';
    $GShift = isset($_GET['gshift']) ? $_GET['gshift'] : '';
    if (strlen($jamA) == 5) {
        $start_date = $Awal . ' ' . $jamA;
    } else {
        $start_date = $Awal . ' 0' . $jamA;
    }
    if (strlen($jamAr) == 5) {
        $stop_date  = $Akhir . ' ' . $jamAr;
    } else {
        $stop_date  = $Akhir . ' 0' . $jamAr;
    }
    if($jamA & $jamAr){
        $where_jam  = "createdatetime BETWEEN '$start_date' AND '$stop_date'";
    }else{
        $where_jam  = "DATE(createdatetime) BETWEEN '$Awal' AND '$Akhir'";
    }

    if($GShift == 'ALL'){
        $where_gshift = "";
    }else{
        $where_gshift = "AND gshift = '$GShift'";
    }
?>
<table border="1" style="width:100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>No. Kartu Kerja</th>
            <th>No. Demand</th>
            <th>Pelanggan</th>
            <th>Buyer</th>
            <th>No. Order</th>
            <th>Jenis Kain</th>
            <th>Warna</th>
            <th>Jam Terima</th>
            <th>Operator Penerima</th>
            <th>Jam Proses</th>
            <th>Operator Matcher</th>
            <th>Pemberi Resep</th>
            <th>Acc Resep</th>
            <th>Oke Ke</th>
            <th>Operator Matcher</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $q_matching_dye    = mysqli_query($con, "SELECT * FROM tbl_matching_dyeing WHERE $where_jam $where_gshift ORDER BY id DESC");
            $no = 1;
        ?>
        <?php while ($row_matching_dye = mysqli_fetch_array($q_matching_dye)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row_matching_dye['nokk'] ?></td>
                <td><?= $row_matching_dye['nodemand'] ?></td>
                <td><?= $row_matching_dye['langganan'] ?></td>
                <td><?= $row_matching_dye['buyer'] ?></td>
                <td><?= $row_matching_dye['no_order'] ?></td>
                <td><?= $row_matching_dye['jenis_kain'] ?></td>
                <td><?= $row_matching_dye['warna'] ?></td>
                <td><?= $row_matching_dye['jam_terima'] ?></td>
                <td><?= $row_matching_dye['operator_penerima'] ?></td>
                <td><?= $row_matching_dye['createdatetime_proses'] ?></td>
                <td><?= $row_matching_dye['operator_matcher'] ?></td>
                <td><?= $row_matching_dye['pemberi_resep'] ?></td>
                <td><?= $row_matching_dye['acc_resep'] ?></td>
                <td><?= $row_matching_dye['ok_ke'] ?></td>
                <td><?= $row_matching_dye['operator_matcher'] ?></td>
                <td><?= $row_matching_dye['note'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
                                