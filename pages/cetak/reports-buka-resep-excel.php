<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename= Report Buka Resep.xls"); //ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php
ini_set("error_reporting", 1);
include "../../koneksi.php";
$Awal   = $_GET['awal'];
$Akhir  = $_GET['akhir'];
$jamA   = $_GET['jam_awal'];
$jamAr  = $_GET['jam_akhir'];
$GShift = $_GET['gshift'];
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
if ($jamA & $jamAr) {
    $where_jam  = "createdatetime BETWEEN '$start_date' AND '$stop_date'";
} else {
    $where_jam  = "DATE(createdatetime) BETWEEN '$Awal' AND '$Akhir'";
}

if ($GShift == 'ALL') {
    $where_gshift = "";
} else {
    $where_gshift = "AND gshift = '$GShift'";
}
?>
<html>

<body>
    <table>
        <thead>
            <!-- <tr>
                <th rowspan="4" colspan="2"><img src="Indo.jpg" alt="" width="70" height="60"></th>
            </tr>
            <tr>
                <th colspan="11" rowspan=""><h2>FORM LAPORAN HARIAN BUKA BON RESEP</h2></th>
            </tr>
            <tr>
                <th align="center" colspan="11" rowspan="2"> FW - 14 - DYE - 26 / 00</th>
            </tr>
            <tr></tr> -->
            <!-- <tr valign="top">
                <td colspan="20">
                    <table width="100%" border="0" class="table-list1">
                        <thead>
                            <tr>
                                <td width="6%" rowspan="4"><img src="Indo.jpg" alt="" width="60" height="60"></td>
                                <td width="94%" rowspan="4">
                                    <div align="center">
                                        <h2>FORM LAPORAN HARIAN BUKA BON RESEP</h2>
                                        <p>FW - 14 - DYE - 26 / 00</p>
                                    </div>
                                </td>
                            </tr>
                        <thead>
                    </table>
                </td>
            </tr> -->
            <tr>
                <td style="width:3%">
                    <div align="center">No.</div>
                </td>
                <td style="width:4%">
                    <div align="center">No. Kartu Kerja</div>
                </td>
                <td style="width:4%">
                    <div align="center">No. Demand</div>
                </td>
                <td style="width:10%">
                    <div align="center">Pelanggan</div>
                </td>
                <td style="width:5%">No. Order</td>
                <td style="width:5%">No. Item</td>
                <td style="width:25%" align="center">Jenis Kain</td>
                <td>Warna</td>
                <td align="center">Bon Resep 1</td>
                <td align="center">Suffix 1</td>
                <td align="center">Bon Resep 2</td>
                <td align="center">Suffix 2</td>
                <td>Operator</td>
                <td>Diperiksa Oleh</td>
                <td>Cek Resep</td>
                <td>Keterangan</td>
                <td>Qty Order</td>
                <td>Kapasitas</td>
                <td>Jumlah Gerobak</td>
                <td>Proses</td>
                <td>Creationdatetime</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $q_bukaresep    = mysqli_query($con, "SELECT
                                                        *
                                                    FROM
                                                        tbl_bukaresep 
                                                    WHERE 
                                                        $where_jam $where_gshift");
            $no = 1;
            ?>
            <?php while ($row_bukaresep = mysqli_fetch_array($q_bukaresep)) { ?>
                <?php
                $sql_ITXVIEWKK  = db2_exec($conn2, "SELECT * FROM ITXVIEWKK WHERE PRODUCTIONORDERCODE = '$row_bukaresep[nokk]'");
                $dt_ITXVIEWKK    = db2_fetch_assoc($sql_ITXVIEWKK);

                $sql_pelanggan_buyer     = db2_exec($conn2, "SELECT TRIM(LANGGANAN) AS PELANGGAN, TRIM(BUYER) AS BUYER FROM ITXVIEW_PELANGGAN 
                                                                WHERE ORDPRNCUSTOMERSUPPLIERCODE = '$dt_ITXVIEWKK[ORDPRNCUSTOMERSUPPLIERCODE]' AND CODE = '$dt_ITXVIEWKK[PROJECTCODE]'");
                $dt_pelanggan_buyer        = db2_fetch_assoc($sql_pelanggan_buyer);

                $sql_qtyorder   = db2_exec($conn2, "SELECT DISTINCT
                                                            GROUPSTEPNUMBER,
                                                            INITIALUSERPRIMARYQUANTITY AS QTY_ORDER,
                                                            INITIALUSERSECONDARYQUANTITY AS QTY_ORDER_YARD
                                                        FROM 
                                                            VIEWPRODUCTIONDEMANDSTEP 
                                                        WHERE 
                                                            PRODUCTIONORDERCODE = '$row_bukaresep[nokk]'
                                                        ORDER BY
                                                            GROUPSTEPNUMBER ASC LIMIT 1");
                $dt_qtyorder    = db2_fetch_assoc($sql_qtyorder);
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row_bukaresep['nokk']; ?></td>
                    <td><?= $row_bukaresep['nodemand']; ?></td>
                    <td><?= $dt_pelanggan_buyer['PELANGGAN']; ?></td>
                    <td><?= $dt_ITXVIEWKK['PROJECTCODE']; ?></td>
                    <td><?= TRIM($dt_ITXVIEWKK['SUBCODE02']) . ' ' . TRIM($dt_ITXVIEWKK['SUBCODE03']); ?></td>
                    <td><?= $dt_ITXVIEWKK['ITEMDESCRIPTION']; ?></td>
                    <td><?= $dt_ITXVIEWKK['WARNA']; ?></td>
                    <td align="center"><?= $row_bukaresep['noresep1']; ?></td>
                    <td align="center"><?= $row_bukaresep['suffix1']; ?></td>
                    <td align="center"><?= $row_bukaresep['noresep2']; ?></td>
                    <td align="center"><?= $row_bukaresep['suffix2']; ?></td>
                    <td><?= $row_bukaresep['personil']; ?></td>
                    <td><?= $row_bukaresep['diperiksa_oleh']; ?></td>
                    <td><?= $row_bukaresep['cek_resep']; ?></td>
                    <td><?= $row_bukaresep['ket']; ?></td>
                    <td><?= number_format($dt_qtyorder['QTY_ORDER'], 2); ?></td>
                    <?php if ($row_bukaresep['kapasitas'] == null) { ?>
                        <td></td>
                    <?php } else { ?>
                        <td><?= $row_bukaresep['kapasitas']; ?></td>
                    <?php } ?>
                    <td><?= $row_bukaresep['jml_gerobak']; ?></td>
                    <td><?= $row_bukaresep['proses']; ?></td>
                    <td><?= $row_bukaresep['createdatetime']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
            </tr>
        </tfoot>
    </table>
</body>

</html>