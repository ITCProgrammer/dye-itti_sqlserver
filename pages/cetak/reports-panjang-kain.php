<?php
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=PLANING REPORT UNTUK PANJANG KAIN PROSES DYEING " . substr($_GET['awal'], 0, 10) . ".xls"); //ganti nama sesuai keperluan
  header('Cache-Control: max-age=0');
?>
<table width="100%" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Tgl</th>
            <th>Fabric Type</th>
            <th>Article Code</th>
            <th>Article Number</th>
            <th>Jenis Kain</th>
            <th>Machine</th>
            <th>Kapasitas</th>
            <th>Keterangan Proses</th>
            <th>Lubang</th>
            <th>Kapasitas Per Lubang</th>
            <th>Pre-Dye width (in)</th>
            <th>Pre-Dye Weight (gsm)</th>
            <th>Total Roll</th>
            <th>Total Qty</th>
            <th>Avg Wt of 1 roll (kg)</th>
            <th>Number of Roll</th>
            <th>L:R</th>
            <th>Cycle Time (s)</th>
            <th>Machine Speed (m/min)</th>
            <th>Blower (%)</th>
            <th>Pump</th>
            <th>Nozzle</th>
            <th>Plaiter</th>
            <th>Weight per length (g/m)</th>
            <th>Length of Loop (m)</th>
            <th>Theoretical m/min</th>
            <th>% loading</th>
            <th>Date</th>
            <th>By</th>
            <th>Prodution Order</th>
            <th>Prodution Demand</th>
            <th>Keterangan</th>
            <th>Lot</th>
            <th>Problem</th>
            <th>Final Inspection</th>
            <th>Result</th>
            <th>Lebar asal Greige</th>
            <th>Gramasi asal Greige</th>
        </tr>
    </thead>
    <tbody>
        <?php
            include "../../koneksi.php";
            $Awal = $_GET['awal'];
            $Akhir = $_GET['akhir'];
            if ($Awal != $Akhir) {
                $Where = " DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$Awal' AND '$Akhir' ";
            } else {
                $Where = " DATE_FORMAT(c.tgl_update, '%Y-%m-%d')='$Tgl' ";
            }

            if ($_GET['shft'] == "ALL") {
                $shft = " ";
            } else {
                $shft = " a.g_shift='$_GET[shft]' AND ";
            }
            $sql = mysqli_query($con, "SELECT
                                            a.tgl_buat,
                                            a.nokk,
                                            a.nodemand,
                                            b.jenis_kain,
                                            b.no_mesin,
                                            b.kapasitas,
                                            CASE
                                                WHEN c.lb1 IS NULL OR c.lb1 = '' THEN 0 ELSE 1
                                            END + 
                                            CASE
                                                WHEN c.lb2 IS NULL OR c.lb2 = '' THEN 0 ELSE 1
                                            END + 
                                            CASE
                                                WHEN c.lb3 IS NULL OR c.lb3 = '' THEN 0 ELSE 1
                                            END + 
                                            CASE
                                                WHEN c.lb4 IS NULL OR c.lb4 = '' THEN 0 ELSE 1
                                            END + 
                                            CASE
                                                WHEN c.lb5 IS NULL OR c.lb5 = '' THEN 0 ELSE 1
                                            END + 
                                            CASE
                                                WHEN c.lb6 IS NULL OR c.lb6 = '' THEN 0 ELSE 1
                                            END +
                                            CASE
                                                WHEN c.lb7 IS NULL OR c.lb7 = '' THEN 0 ELSE 1
                                            END + 
                                            CASE
                                                WHEN c.lb8 IS NULL OR c.lb8 = '' THEN 0 ELSE 1
                                            END AS Lubang,
                                            c.lebar_a,
                                            c.gramasi_a,
                                            c.rol,
                                            c.bruto,
                                            c.l_r,
                                            c.l_r_2,
                                            c.cycle_time,
                                            c.rpm,
                                            c.blower,
                                            c.tekanan,
                                            c.nozzle,
                                            c.plaiter,
                                            b.lot,
                                            c.tgl_update,
                                            a.proses
                                        FROM
                                            tbl_schedule b
                                        LEFT JOIN  tbl_montemp c ON c.id_schedule = b.id
                                        LEFT JOIN tbl_hasilcelup a ON a.id_montemp=c.id
                                        WHERE
                                            $shft 
                                            $Where
                                        ORDER BY
                                            b.no_mesin ASC");

            $no = 1;

            $c = 0;

            while ($rowd = mysqli_fetch_array($sql)) {
	            ini_set("error_reporting", 1);
                $q_itxviewkk        = db2_exec($conn2, "SELECT 
                                                            LISTAGG(TRIM(SUBCODE01), '') AS SUBCODE01,
                                                            LISTAGG(TRIM(SUBCODE02), '') AS SUBCODE02,
                                                            LISTAGG(TRIM(SUBCODE03), '') AS SUBCODE03,
                                                            LISTAGG(TRIM(SUBCODE04), '') AS SUBCODE04
                                                        FROM 
                                                            (SELECT
                                                                TRIM(SUBCODE01) AS SUBCODE01,
                                                                TRIM(SUBCODE02) AS SUBCODE02,
                                                                TRIM(SUBCODE03) AS SUBCODE03,
                                                                TRIM(SUBCODE04) AS SUBCODE04
                                                            FROM
                                                                ITXVIEWKK
                                                            WHERE
                                                                PRODUCTIONORDERCODE = '$rowd[nokk]'
                                                            GROUP BY 
                                                                SUBCODE01,
                                                                SUBCODE02,
                                                                SUBCODE03,
                                                                SUBCODE04)");
                $row_itxviewkk      = db2_fetch_assoc($q_itxviewkk);

                $q_lg_standart  = db2_exec($conn2, "SELECT 
                                                        a.VALUEDECIMAL AS LEBAR,
                                                        a2.VALUEDECIMAL AS GRAMASI
                                                    FROM 
                                                        PRODUCT p 
                                                    LEFT JOIN ADSTORAGE a ON a.UNIQUEID = p.ABSUNIQUEID AND a.FIELDNAME = 'Width'
                                                    LEFT JOIN ADSTORAGE a2 ON a2.UNIQUEID = p.ABSUNIQUEID AND a2.FIELDNAME = 'GSM'
                                                    WHERE 
                                                        SUBCODE01 = '$row_itxviewkk[SUBCODE01]' 
                                                        AND SUBCODE02 = '$row_itxviewkk[SUBCODE02]' 
                                                        AND SUBCODE03 = '$row_itxviewkk[SUBCODE03]'
                                                        AND SUBCODE04 = '$row_itxviewkk[SUBCODE04]' 
                                                        AND ITEMTYPECODE = 'KGF'");
                $d_lg_standart  = db2_fetch_assoc($q_lg_standart);
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= substr($rowd['tgl_buat'], 0,10); ?></td>
                <td><?= $row_itxviewkk['SUBCODE01']; ?></td>
                <td><?= $row_itxviewkk['SUBCODE02']; ?></td>
                <td><?= $row_itxviewkk['SUBCODE03']; ?></td>
                <td><?= $rowd['jenis_kain'] ?></td>
                <td><?= $rowd['no_mesin'] ?></td>
                <td><?= $rowd['kapasitas'] ?></td>
                <td><?= $rowd['proses'] ?></td>
                <td><?= $rowd['Lubang'] ?></td>
                <td><?php if($rowd['Lubang'] != 0) { echo number_format($rowd['kapasitas'] / $rowd['Lubang'], 2); } ?></td>
                <td><?= $rowd['lebar_a']; ?></td>
                <td><?= $rowd['gramasi_a']; ?></td>
                <td><?= $rowd['rol']; ?></td>
                <td><?= $rowd['bruto']; ?></td>
                <td><?php if($rowd['rol'] != 0 && is_numeric($rowd['rol'])){ echo number_format($rowd['bruto'] / $rowd['rol'], 2); } ?></td>
                <td><?php if($rowd['Lubang'] != 0 && $rowd['rol'] != 0){ echo number_format($rowd['rol'] / $rowd['Lubang'], 2); } ?></td>
                <td><?= $rowd['l_r'].'/'.$rowd['l_r_2']; ?></td>
                <td><?= $rowd['cycle_time']; ?></td>
                <td><?= $rowd['rpm']; ?></td>
                <td><?= $rowd['blower']; ?></td>
                <td><?= $rowd['tekanan']; ?></td>
                <td><?= $rowd['nozzle']; ?></td>
                <td><?= $rowd['plaiter']; ?></td>
                <td><?= number_format(($rowd['lebar_a'] * $rowd['gramasi_a']) / 39.3701, 2) ; ?></td>
                <td>
                    <?php if($rowd['rol'] != 0 && $rowd['lebar_a'] != 0 && $rowd['gramasi_a'] != 0 && $rowd['Lubang'] != 0) : ?>
                        <?= number_format(($rowd['bruto'] / $rowd['rol']) * ($rowd['rol'] / $rowd['Lubang']) / (($rowd['lebar_a'] * $rowd['gramasi_a']) / 39.3701) * 1000, 2); ?>
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($rowd['rol'] != 0 && $rowd['lebar_a'] != 0 && $rowd['gramasi_a'] != 0 && !empty($rowd['cycle_time']) && $rowd['Lubang'] != 0) : ?>
                        <?= number_format(($rowd['bruto'] / $rowd['rol']) * ($rowd['rol'] / $rowd['Lubang']) / (($rowd['lebar_a'] * $rowd['gramasi_a']) / 39.3701) * 1000 / ($rowd['cycle_time'] / 60), 2); ?>
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($rowd['kapasitas'] != 0){echo number_format($rowd['bruto'] / $rowd['kapasitas'], 2) * 100; } ?>%
                </td>
                <td></td><!-- DATE -->
                <td></td><!-- BY -->
                <td>`<?= $rowd['nokk']; ?></td>
                <td>`<?= $rowd['nodemand']; ?></td>
                <td></td><!-- KETERANGAN -->
                <td>`<?= $rowd['lot']; ?></td>
                <td>
                    <?php
                        $q_NCP      = mysqli_query($cond, "SELECT * FROM `tbl_ncp_qcf_now` WHERE prod_order = '$rowd[nokk]'");
                        $row_NCP    = mysqli_fetch_assoc($q_NCP);
                        echo isset($row_NCP['masalah']) ? $row_NCP['masalah'] : '';
                        echo isset($row_NCP['masalah_dominan']) ? $row_NCP['masalah_dominan'] : '';
                        // if($row_NCP['prod_order']){
                        //     echo $row_NCP['masalah'].' - '.$row_NCP['masalah_dominan'];
                        // }else{
                        //     echo '-';
                        // }
                    ?>
                </td><!-- Problem -->
                <td>
                    <?php
                        $q_commentline      = db2_exec($conn2, "SELECT LISTAGG(COMMENTTEXT, ' ') AS COMMENTTEXT FROM PRODUCTIONDEMANDSTEPCOMMENT WHERE PRODEMANDSTEPPRODEMANDCODE = '$rowd[nodemand]'");
                        $row_commentline    = db2_fetch_assoc($q_commentline);
                        echo isset($row_commentline['COMMENTTEXT']) ? $row_commentline['COMMENTTEXT'] : '';

                        // if($row_commentline['PRODEMANDSTEPPRODEMANDCODE']){
                        //     echo $row_commentline['COMMENTTEXT'];
                        // }else{
                        //     echo '-';
                        // }
                    ?>
                </td><!-- Final Inspection -->
                <td></td><!-- Result -->
                <td><?= number_format($d_lg_standart['LEBAR'], 0); ?></td><!-- lebar asal Greige -->
                <td><?= number_format($d_lg_standart['GRAMASI'], 0); ?></td><!-- gramasi asal Greige -->
            </tr>
        <?php } ?>
    </tbody>
</table>