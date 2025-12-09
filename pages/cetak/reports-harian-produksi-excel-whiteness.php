<?php
header("content-type:application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report-produksi-whiteness" . substr($_GET['awal'], 0, 10) . ".xls");
?>
<?php
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../koneksiLAB.php";
include "../../tgl_indo.php";
//--
$idkk = $_REQUEST['idkk'];
$act = $_GET['g'];
//-
$qTgl = mysqli_query($con, "SELECT DATE_FORMAT(now(),'%Y-%m-%d') as tgl_skrg, DATE_FORMAT(now(),'%Y-%m-%d')+ INTERVAL 1 DAY as tgl_besok");
$rTgl = mysqli_fetch_array($qTgl);
$Awal = $_GET['awal'];
$Akhir = $_GET['akhir'];
if ($Awal == $Akhir) {
  $TglPAl = substr($Awal, 0, 10);
  $TglPAr = substr($Akhir, 0, 10);
} else {
  $TglPAl = $Awal;
  $TglPAr = $Akhir;
}
$shft = $_GET['shft'];
?>

<body>
  <strong>Periode: <?php echo $TglPAl; ?> s/d <?php echo $TglPAr; ?></strong><br>
  <strong>Shift: <?php echo $shft; ?></strong><br />
  <table width="100%" border="1">
    <thead>
      <tr>
        <th bgcolor="#99FF99">NO.</th>
        <th bgcolor="#99FF99">PRODUCTION ORDER</th>
        <th bgcolor="#99FF99">PRODUCTION DEMAND</th>
        <!-- <th bgcolor="#99FF99">ORIGINAL PD CODE</th> -->
        <th bgcolor="#99FF99">NO ITEM</th>
        <th bgcolor="#99FF99">COLOR GROUP</th>
        <th bgcolor="#99FF99">FABRIC TYPE</th>
        <!-- <th bgcolor="#99FF99">LIGHT/DARK</th> -->
        <th bgcolor="#99FF99">JENIS KAIN</th>
        <th bgcolor="#99FF99">GRAMASI</th>
        <th bgcolor="#99FF99">QTY</th>
        <th bgcolor="#99FF99">NOMOR MESIN</th>\
        <th bgcolor="#99FF99">KAPASITAS MESIN</th>
        <th bgcolor="#99FF99">WARNA</th>
        <th bgcolor="#99FF99">NO WARNA</th>
        <th bgcolor="#99FF99">RESEP 1</th>
        <th bgcolor="#99FF99">RESEP 2</th>
        <th bgcolor="#99FF99">WAKTU IN</th>
        <th bgcolor="#99FF99">PRD. RSV. LINK GROUP CODE</th>
        <th bgcolor="#99FF99">WHITENESS</th>
        <th bgcolor="#99FF99">TINT</th>
        <th bgcolor="#99FF99">YELLOWNESS</th>
        <th bgcolor="#99FF99">LR</th>
        <th bgcolor="#99FF99">SUFFIX</th>
        <th bgcolor="#99FF99">CONSAGENT</th>
        <th bgcolor="#99FF99">LONG DESCRIPTION</th>
        <th bgcolor="#99FF99">SHORT DESCRIPTION</th>
        <th bgcolor="#99FF99">SEARCH DESCRIPTION</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $Awal     = $_GET['awal'];
      $Akhir    = $_GET['akhir'];
      $GShift   = $_GET['shft'];

      $Tgl = substr($Awal, 0, 10);
      if ($GShift == "ALL") {
        $shft = " ";
      } else {
        $shft = " if(ISNULL(a.g_shift),c.g_shift,a.g_shift)='$GShift' AND ";
      }

      $jamA   = $_GET['awal'];
      $jamAr  = $_GET['akhir'];
      if (strlen($jamA) == 5) {
        $start_date = $jamA;
      } else {
        $start_date = $jamA;
      }
      if (strlen($jamAr) == 5) {
        $stop_date  = $jamAr;
      } else {
        $stop_date  = $jamAr;
      }
  
      $Where = " DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$start_date' AND '$stop_date' ";
      if ($Awal != "" and $Akhir != "") {
        $Where1 = "WHERE NOT x.nokk IS NULL";
      } else {
        $Where1 = " WHERE a.id='' AND NOT x.nokk IS NULL";
      }
      $sql = mysqli_query($con, "SELECT x.*,a.no_mesin as mc,a.no_mc_lama as mc_lama FROM tbl_mesin a
                                  LEFT JOIN
                                  (SELECT
                                    a.kd_stop,
                                    a.mulai_stop,
                                    a.selesai_stop,
                                    a.ket,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama_proses,
                                    a.status as sts,
                                    TIME_FORMAT(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))),'%H') as jam,
                                    TIME_FORMAT(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))),'%i') as menit,
                                    a.point,
                                    DATE_FORMAT(a.mulai_stop,'%Y-%m-%d') as t_mulai,
                                    DATE_FORMAT(a.selesai_stop,'%Y-%m-%d') as t_selesai,
                                    TIME_FORMAT(a.mulai_stop,'%H:%i') as j_mulai,
                                    TIME_FORMAT(a.selesai_stop,'%H:%i') as j_selesai,
                                    TIMESTAMPDIFF(MINUTE,a.mulai_stop,a.selesai_stop) as lama_stop_menit,
                                    a.acc_keluar,
                                    if(a.proses='' or ISNULL(a.proses),b.proses,a.proses) as proses,
                                    b.buyer,
                                    b.langganan,
                                    b.no_order,
                                    b.jenis_kain,
                                    b.no_mesin,
                                    b.warna,
                                    b.lot,
                                    b.energi,
                                    b.dyestuff,	
                                    b.ket_status,
                                    b.kapasitas,
                                    b.loading,
                                    b.resep,
                                    b.kategori_warna,
                                    b.target,
                                    c.l_r,
                                    c.rol,
                                    c.bruto,
                                    c.pakai_air,
                                    c.no_program,
                                    c.pjng_kain,
                                    c.cycle_time,
                                    c.rpm,
                                    c.tekanan,
                                    c.nozzle,
                                    c.plaiter,
                                    c.blower,
                                    DATE_FORMAT(c.tgl_buat,'%Y-%m-%d') as tgl_in,
                                    DATE_FORMAT(a.tgl_buat,'%Y-%m-%d') as tgl_out,
                                    DATE_FORMAT(c.tgl_buat,'%H:%i') as jam_in,
                                    DATE_FORMAT(a.tgl_buat,'%H:%i') as jam_out,
                                    if(ISNULL(a.g_shift),c.g_shift,a.g_shift) as shft,
                                    a.operator_keluar,
                                    a.k_resep,
                                    a.status,
                                    a.proses_point,
                                    a.analisa,
                                    b.nokk,
                                    b.no_warna,
                                    b.lebar,
                                    b.gramasi,
                                    c.carry_over,
                                    b.no_hanger,
                                    b.no_item,
                                    b.po,	
                                    b.tgl_delivery,
                                    b.kk_kestabilan,
                                    b.kk_normal,
                                    c.air_awal,
                                    a.air_akhir,
                                    c.nokk_legacy,
                                    c.loterp,
                                    c.nodemand,
                                    a.tambah_obat,
                                    a.tambah_obat1,
                                    a.tambah_obat2,
                                    a.tambah_obat3,
                                    a.tambah_obat4,
                                    a.tambah_obat5,
                                    a.tambah_obat6,
                                    c.leader,
                                    b.suffix,
                                    b.suffix2,
                                    c.l_r_2,
                                    c.lebar_fin,
                                    c.grm_fin,
                                    c.lebar_a,
                                    c.gramasi_a,
                                    c.operator,
                                    a.tambah_dyestuff,
                                    a.arah_warna,
                                    a.status_warna,
                                    c.tgl_update
                                  FROM
                                    tbl_schedule b
                                    LEFT JOIN  tbl_montemp c ON c.id_schedule = b.id
                                    LEFT JOIN tbl_hasilcelup a ON a.id_montemp=c.id
                                  WHERE
                                      $shft
                                      $Where
                                      ) x ON (a.no_mesin=x.no_mesin or a.no_mc_lama=x.no_mesin) 
                                  $Where1 
                                  ORDER BY tgl_update DESC");

      $no = 1;
      while ($rowd = mysqli_fetch_array($sql)) {
        $sql_ITXVIEWKK  = db2_exec($conn2, "SELECT * FROM ITXVIEWKK WHERE PRODUCTIONORDERCODE = '$rowd[nokk]' LIMIT 1");
        $dt_ITXVIEWKK    = db2_fetch_assoc($sql_ITXVIEWKK);

        $q_uploadspectro    = mysqli_query($con_nowprd, "SELECT * FROM `upload_spectro` WHERE SUBSTR(batch_name, 1,8) = '$rowd[nokk]'");
        $data_uploadspectro = mysqli_fetch_assoc($q_uploadspectro);

        if (!empty($data_uploadspectro)) {
          $q_rsv_link_group   = db2_exec($conn2, "SELECT
                                                      q2.LINE,
                                                      q.PRODUCTIONORDERCODE,
                                                      LISTAGG('''' || a.valueint || '''', ',') AS STEPNUMBER,
                                                      LISTAGG(TRIM(q.OPERATIONCODE), ', ') AS OPERATIONCODE
                                                    FROM
                                                      QUALITYDOCUMENT q
                                                    LEFT JOIN ADSTORAGE a ON a.UNIQUEID = q.ABSUNIQUEID AND a.FIELDNAME = 'GroupStepNumber'
                                                    LEFT JOIN QUALITYDOCLINE q2 ON q2.QUALITYDOCUMENTHEADERLINE = q.HEADERLINE
                                                                  AND (TRIM(q2.CHARACTERISTICCODE) = 'WHITENESS'
                                                                    OR TRIM(q2.CHARACTERISTICCODE) = 'YELLOWNESS'
                                                                    OR TRIM(q2.CHARACTERISTICCODE) = 'TINT')
                                                                  AND NOT q2.VALUEQUANTITY = 0
                                                    WHERE
                                                      q.PRODUCTIONORDERCODE = '$rowd[nokk]'
                                                      AND q2.LINE = 11
                                                    GROUP BY
                                                      q2.LINE,
                                                      q.PRODUCTIONORDERCODE");
          $row_rsv_link_group = db2_fetch_assoc($q_rsv_link_group);

          $q_whiteness    = db2_exec($conn2, "SELECT
                                                      q2.LINE,
                                                      q.PRODUCTIONORDERCODE,
                                                      LISTAGG(TRIM(q.OPERATIONCODE) || ' = ' || DECIMAL(q2.VALUEQUANTITY, 5,2), ', ') AS WHITENESS,
                                                      q2.CHARACTERISTICCODE	
                                                  FROM
                                                      QUALITYDOCUMENT q  
                                                  LEFT JOIN ADSTORAGE a ON a.UNIQUEID = q.ABSUNIQUEID AND a.FIELDNAME = 'GroupStepNumber'
                                                  LEFT JOIN QUALITYDOCLINE q2 ON q2.QUALITYDOCUMENTHEADERLINE = q.HEADERLINE 
                                                                AND (TRIM(q2.CHARACTERISTICCODE) = 'WHITENESS'
                                                                  OR TRIM(q2.CHARACTERISTICCODE) = 'YELLOWNESS'
                                                                  OR TRIM(q2.CHARACTERISTICCODE) = 'TINT')
                                                                AND NOT q2.VALUEQUANTITY = 0						
                                                  WHERE
                                                      q.PRODUCTIONORDERCODE = '$rowd[nokk]'
                                                      AND q2.LINE = 11
                                                      AND TRIM(q2.CHARACTERISTICCODE) = 'WHITENESS'
                                                  GROUP BY
                                                      q2.LINE,
                                                      q.PRODUCTIONORDERCODE,
                                                      q2.CHARACTERISTICCODE");
          $row_whiteness  = db2_fetch_assoc($q_whiteness);

          $q_tint    = db2_exec($conn2, "SELECT
                                              q2.LINE,
                                              q.PRODUCTIONORDERCODE,
                                              LISTAGG(TRIM(q.OPERATIONCODE) || ' = ' || DECIMAL(q2.VALUEQUANTITY, 5,2), ', ') AS TINT,
                                              q2.CHARACTERISTICCODE	
                                          FROM
                                              QUALITYDOCUMENT q  
                                          LEFT JOIN ADSTORAGE a ON a.UNIQUEID = q.ABSUNIQUEID AND a.FIELDNAME = 'GroupStepNumber'
                                          LEFT JOIN QUALITYDOCLINE q2 ON q2.QUALITYDOCUMENTHEADERLINE = q.HEADERLINE 
                                                        AND (TRIM(q2.CHARACTERISTICCODE) = 'WHITENESS'
                                                          OR TRIM(q2.CHARACTERISTICCODE) = 'YELLOWNESS'
                                                          OR TRIM(q2.CHARACTERISTICCODE) = 'TINT')
                                                        AND NOT q2.VALUEQUANTITY = 0						
                                          WHERE
                                              q.PRODUCTIONORDERCODE = '$rowd[nokk]'
                                              AND q2.LINE = 13
                                              AND TRIM(q2.CHARACTERISTICCODE) = 'TINT'
                                          GROUP BY
                                              q2.LINE,
                                              q.PRODUCTIONORDERCODE,
                                              q2.CHARACTERISTICCODE");
          $row_tint  = db2_fetch_assoc($q_tint);

          $q_yellowness    = db2_exec($conn2, "SELECT
                                                    q2.LINE,
                                                    q.PRODUCTIONORDERCODE,
                                                    LISTAGG(TRIM(q.OPERATIONCODE) || ' = ' || DECIMAL(q2.VALUEQUANTITY, 5,2), ', ') AS YELLOWNESS,
                                                    q2.CHARACTERISTICCODE	
                                                FROM
                                                    QUALITYDOCUMENT q  
                                                LEFT JOIN ADSTORAGE a ON a.UNIQUEID = q.ABSUNIQUEID AND a.FIELDNAME = 'GroupStepNumber'
                                                LEFT JOIN QUALITYDOCLINE q2 ON q2.QUALITYDOCUMENTHEADERLINE = q.HEADERLINE 
                                                              AND (TRIM(q2.CHARACTERISTICCODE) = 'WHITENESS'
                                                                OR TRIM(q2.CHARACTERISTICCODE) = 'YELLOWNESS'
                                                                OR TRIM(q2.CHARACTERISTICCODE) = 'TINT')
                                                              AND NOT q2.VALUEQUANTITY = 0						
                                                WHERE
                                                    q.PRODUCTIONORDERCODE = '$rowd[nokk]'
                                                    AND q2.LINE = 12
                                                    AND TRIM(q2.CHARACTERISTICCODE) = 'YELLOWNESS'
                                                GROUP BY
                                                    q2.LINE,
                                                    q.PRODUCTIONORDERCODE,
                                                    q2.CHARACTERISTICCODE");
          $row_yellowness  = db2_fetch_assoc($q_yellowness);

          if ($row_rsv_link_group['STEPNUMBER']) {
            $q_lr   = db2_exec($conn2, "SELECT 
                                            LISTAGG(TRIM(SUBCODE01)) AS RCODE,
                                            LISTAGG(TRIM(SUFFIXCODE)) AS RCODESUFFIX,
                                            LISTAGG(TRIM(PRODRESERVATIONLINKGROUPCODE) || ' = ' || DECIMAL(LR, 5,2), ', ') AS LR,
                                            LISTAGG(TRIM(PRODRESERVATIONLINKGROUPCODE) || ' = ' || TRIM(SUBCODE01) || '-' || TRIM(SUFFIXCODE), ', ') AS SUFFIX,
                                            LISTAGG(TRIM(PRODRESERVATIONLINKGROUPCODE) || ' = ' || TRIM(LONGDESCRIPTION), ', ') AS LONGDESCRIPTION,
                                            LISTAGG(TRIM(PRODRESERVATIONLINKGROUPCODE) || ' = ' || TRIM(SHORTDESCRIPTION), ', ') AS SHORTDESCRIPTION,
                                            LISTAGG(TRIM(PRODRESERVATIONLINKGROUPCODE) || ' = ' || TRIM(SEARCHDESCRIPTION), ', ') AS SEARCHDESCRIPTION
                                          FROM (
                                            SELECT 
                                              DISTINCT 
                                              p.PRODRESERVATIONLINKGROUPCODE,
                                              p.PICKUPQUANTITY AS LR,
                                              p.SUBCODE01,
                                              p.SUFFIXCODE,
                                              r.LONGDESCRIPTION,
                                              r.SHORTDESCRIPTION,
                                              r.SEARCHDESCRIPTION
                                            FROM 
                                              PRODUCTIONRESERVATION p 
                                            LEFT JOIN RECIPE r ON r.SUBCODE01 = p.SUBCODE01 AND r.SUFFIXCODE = p.SUFFIXCODE 
                                            LEFT JOIN VIEWPRODUCTIONDEMANDSTEP v ON v.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND v.GROUPSTEPNUMBER = p.GROUPSTEPNUMBER
                                            WHERE	
                                              p.PRODUCTIONORDERCODE = '$rowd[nokk]'  
                                              AND 
                                              CASE 
                                                WHEN v.STEPTYPE = 3 THEN p.GROUPSTEPNUMBER IN ($row_rsv_link_group[STEPNUMBER])
                                                ELSE p.STEPNUMBER IN ($row_rsv_link_group[STEPNUMBER])
                                              END 
                                              AND p.ITEMNATURE = 9
                                              AND SUBSTR(p.SUBCODE01, 1,2) = 'SC' 
                                            GROUP BY
                                              p.PRODRESERVATIONLINKGROUPCODE,
                                              p.PICKUPQUANTITY,
                                              p.SUBCODE01,
                                              p.SUFFIXCODE,
                                              r.LONGDESCRIPTION,
                                              r.SHORTDESCRIPTION,
                                              r.SEARCHDESCRIPTION)");
            $row_lr = db2_fetch_assoc($q_lr);

            $q_detail_scouring  = db2_exec($conn2, "SELECT
                                                        LISTAGG(i.LONGDESCRIPTION || '(' || CAST(i.CONSUMPTION AS DECIMAL(10,2)) || ')', ', ') AS DESKRIPSI,
                                                        LISTAGG(i.COMMENTLINE) AS DESKRIPSI2
                                                    FROM
                                                      ITXVIEWRESEP i
                                                    WHERE
                                                      PRODUCTIONORDERCODE = '$rowd[nokk]'
                                                      AND SUBCODE01_RESERVATION = '$row_lr[RCODE]'
                                                      AND SUFFIXCODE_RESERVATION = '$row_lr[RCODESUFFIX]'
                                                      AND COMPANYCODE = '100'");
            $row_detail_scouring = db2_fetch_assoc($q_detail_scouring);

          }

          $prd_rsv_link_group   = $row_rsv_link_group['OPERATIONCODE'];
          $whiteness            = $row_whiteness['WHITENESS'];
          $tint                 = $row_tint['TINT'];
          $yellowness           = $row_yellowness['YELLOWNESS'];
          $LR                   = $row_lr['LR'];
          $SUFFIX               = $row_lr['SUFFIX'];
          $LONGDESCRIPTION      = $row_lr['LONGDESCRIPTION'];
          $SHORTDESCRIPTION     = $row_lr['SHORTDESCRIPTION'];
          $SEARCHDESCRIPTION    = $row_lr['SEARCHDESCRIPTION'];
          $detail_scouring      = $row_detail_scouring['DESKRIPSI'].','.$row_detail_scouring['DESKRIPSI2'];
        } else {
          $prd_rsv_link_group   = '';
          $whiteness            = '';
          $tint                 = '';
          $yellowness           = '';
          $LR                   = '';
          $SUFFIX               = '';
          $LONGDESCRIPTION      = '';
          $SHORTDESCRIPTION     = '';
          $SEARCHDESCRIPTION    = '';
          $detail_scouring      = '';

        }
      ?>
        <tr valign="top">
          <td><?= $no++; ?></td>
          <td>'<?= $rowd['nokk']; ?></td>
          <td>'<?= $rowd['nodemand']; ?></td>
          <!-- <td><?= $d_orig_pd_code['ORIGINALPDCODE']; ?></td> -->
          <td><?= $rowd['no_hanger']; ?></td>
          <td><?= $dt_ITXVIEWKK['COLORGROUP']; ?></td>
          <td><?= $dt_ITXVIEWKK['SUBCODE01']; ?></td>
          <!-- <td>
            <?php
              // $q_variant    = db2_exec($conn2, "SELECT TRIM(SUBCODE04) AS SUBCODE04 FROM PRODUCTIONRESERVATION WHERE PRODUCTIONORDERCODE = '$row_whiteness[PRODUCTIONORDERCODE]' AND (ITEMTYPEAFICODE = 'KGF' OR ITEMTYPEAFICODE = 'FKG')");
              // $row_variant  = db2_fetch_assoc($q_variant);
              // echo $row_variant['SUBCODE04'];
            ?>
          </td> -->
          <td><?= $rowd['jenis_kain']; ?></td>
          <td><?= $rowd['gramasi']; ?></td>
          <td><?= $rowd['bruto']; ?></td>
          <td><?= $rowd['mc']; ?></td>
          <td><?= $rowd['kapasitas']; ?></td>
          <td><?= $rowd['warna']; ?></td>
          <td><?= $rowd['no_warna']; ?></td>
          <td><?= $rowd['suffix']; ?></td>
          <td><?= $rowd['suffix2']; ?></td>
          <td><?= $rowd['tgl_in'] . ' ' . $rowd['jam_in']; ?></td>
          <td><?= $prd_rsv_link_group ?></td>
          <td><?= $whiteness; ?></td>
          <td><?= $tint; ?></td>
          <td><?= $yellowness; ?></td>
          <td><?= $LR; ?></td>
          <td><?= $SUFFIX; ?></td>
          <td><?= $detail_scouring; ?></td>
          <td><?= $LONGDESCRIPTION ?></td>
          <td><?= $SHORTDESCRIPTION ?></td>
          <td><?= $SEARCHDESCRIPTION ?></td>
        </tr>
    </tbody>
  <?php } ?>
  </table>
</body>