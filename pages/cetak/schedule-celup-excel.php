<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=schedule-produksi-dye-" . substr(date("Y-m-d-H-i"), 0, 20) . ".xls"); //ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php
ini_set("error_reporting", 1);
include "../../koneksi.php";
$Awal = $_GET['Awal'];
$Akhir = $_GET['Akhir'];
$qTgl = sqlsrv_query(
  $con,
  "SELECT
     CONVERT(varchar(16), GETDATE(), 120) AS tgl_skrg,
     CONVERT(varchar(10), DATEADD(DAY, 1, GETDATE()), 120) AS tgl_besok,
     CONVERT(varchar(8), GETDATE(), 108) AS jam_skrg"
);
$rTgl = sqlsrv_fetch_array($qTgl, SQLSRV_FETCH_ASSOC);
if ($Awal != "") {
  $tgl = substr($Awal, 0, 10);
  $jam = $Awal;
} else {
  $tgl = $rTgl['tgl_skrg'];
  $jam = $rTgl['jam_skrg'];
}
?>

<body>
<?php
function format_tanggal_sqlsrv($value) {
	if ($value instanceof DateTime) {
		return $value->format('Y-m-d');
	}
	return $value;
}
?>
  <strong>Tgl: <?php echo $tgl . " " . $jam; ?></strong><br />
  <table width="100%" border="1">
    <tr>
      <th bgcolor="#99FF99">KAPASITAS</th>
      <th bgcolor="#99FF99">NO MC</th>
      <th bgcolor="#99FF99">NO. URUT</th>
      <th bgcolor="#99FF99">LANGGANAN</th>
      <th bgcolor="#99FF99">BUYER</th>
      <th bgcolor="#99FF99">NO PO</th>
      <th bgcolor="#99FF99">NO ORDER</th>
      <th bgcolor="#99FF99">JENIS KAIN</th>
      <th bgcolor="#99FF99">WARNA</th>
      <th bgcolor="#99FF99">NO WARNA</th>
      <th bgcolor="#99FF99">LOT</th>
      <th bgcolor="#99FF99">TANGGAL DELIVERY</th>
      <th bgcolor="#99FF99">ROLL</th>
      <th bgcolor="#99FF99">QUANTITY</th>
      <th bgcolor="#99FF99">KETERANGAN</th>
      <th bgcolor="#99FF99">SUFFIX</th>
      <th bgcolor="#99FF99">SUFFIX 2</th>
      <th bgcolor="#99FF99">NO KK</th>
      <th bgcolor="#99FF99">NO DEMAND</th>
      <th bgcolor="#99FF99">NO GEROBAK</th>
      <th bgcolor="#99FF99">JML GEROBAK</th>
    </tr>
    <?php
      $sqlText = "SELECT
                    kapasitas,
                    no_mesin,
                    no_urut,
                    STRING_AGG(lot, '/') AS lot,
                    CASE WHEN COUNT(lot) > 1 THEN 'Gabung Kartu' ELSE '' END AS ket_kartu,
                    CASE WHEN COUNT(lot) > 1 THEN '(' + CAST(COUNT(lot) AS varchar(10)) + 'kk)' ELSE '' END AS kk,
                    MAX(buyer) AS buyer,
                    MAX(langganan) AS langganan,
                    MAX(po) AS po,
                    STRING_AGG(no_order, '-') AS no_order,
                    MAX(no_resep) AS no_resep,
                    nokk,
                    MAX(jenis_kain) AS jenis_kain,
                    MAX(warna) AS warna,
                    MAX(no_warna) AS no_warna,
                    SUM(rol) AS rol,
                    SUM(bruto) AS bruto,
                    MAX(proses) AS proses,
                    MAX(ket_status) AS ket_status,
                    MAX(tgl_delivery) AS tgl_delivery,
                    MAX(ket_kain) AS ket_kain,
                    STRING_AGG(personil, ',') AS personil,
                    MAX(mc_from) AS mc_from,
                    MAX(suffix) AS suffix,
                    MAX(suffix2) AS suffix2,
                    MAX(no_hanger) AS no_hanger,
                    nodemand
                  FROM
                    db_dying.tbl_schedule
                  WHERE
                    status <> 'selesai'";

      $params = array();
      if ($Awal != "") {
        $sqlText .= " AND tgl_update BETWEEN ? AND ?";
        $params[] = $Awal;
        $params[] = $Akhir;
      }

      $sqlText .= "
                  GROUP BY
                    kapasitas,
                    no_mesin,
                    no_urut,
                    nokk,
                    nodemand
                  ORDER BY
                    kapasitas DESC, no_mesin ASC";

      $sql = sqlsrv_query($con, $sqlText, $params);
      $no = 1;
      $c = 0;
      $totrol = 0;
      $totberat = 0;

      while ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
    ?>
      <tr valign="top">
        <td valign="top"><?php echo $rowd['kapasitas']; ?></td>
        <td valign="top">'<?php echo $rowd['no_mesin']; ?></td>
        <td valign="top"><?php echo $rowd['no_urut']; ?></td>
        <td valign="top"><?php echo $rowd['langganan']; ?></td>
        <td valign="top"><?php echo $rowd['buyer']; ?></td>
        <td valign="top"><?php echo $rowd['po']; ?></td>
        <td valign="top"><?php echo $rowd['no_order']; ?></td>
        <td valign="top"><?php echo $rowd['jenis_kain']; ?></td>
        <td valign="top"><?php echo $rowd['warna']; ?></td>
        <td valign="top"><?php echo $rowd['no_hanger']; ?>/<?php echo $rowd['no_warna']; ?></td>
        <td valign="top">'<?php echo $rowd['lot']; ?></td>
        <td valign="top"><?php echo format_tanggal_sqlsrv($rowd['tgl_delivery']); ?></td>
        <td align="right" valign="top"><?php echo $rowd['rol'] . $rowd['kk']; ?></td>
        <td align="right" valign="top"><?php echo $rowd['bruto']; ?></td>
        <td><?php echo $rowd['ket_status']; ?><br>
          <?php echo $rowd['personil']; ?><br>
          <?php echo $rowd['ket_kain']; ?><br>
          <?php echo $rowd['mc_from']; ?> </td>
        <td valign="top">'<?php echo $rowd['suffix']; ?></td>
        <td valign="top">'<?php echo $rowd['suffix2']; ?></td>
        <td valign="top">'<?php echo $rowd['nokk']; ?></td>
        <td valign="top">'<?php echo $rowd['nodemand']; ?></td>
        <!-- pencarian gerobak -->
          <?php 
            $q_iptip    = db2_exec($conn2, "SELECT DISTINCT
                                                  PRODUCTIONORDERCODE,
                                                  REPLACE(LISTAGG( '`'|| PRODUCTIONDEMANDCODE || '`', ', '), '`', '''')  AS PRODUCTIONDEMANDCODE2,
                                                  LISTAGG(PRODUCTIONDEMANDCODE, ', ')  AS PRODUCTIONDEMANDCODE,
                                                  STEPNUMBER,
                                                  OPERATIONCODE,
                                                  STATUS_OPERATION,
                                                  HANGER,
                                                  NO_WARNA,
                                                  WARNA,
                                                  SUBCODE06,
                                                  OPERATIONGROUPCODE,
                                                  ABSUNIQUEID_OPERATION,
                                                  CREATIONDATETIME
                                              FROM
                                                  (SELECT	
                                                      TRIM(p.PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
                                                      TRIM(p.PRODUCTIONDEMANDCODE) AS PRODUCTIONDEMANDCODE,
                                                      p.STEPNUMBER,
                                                      TRIM(p.OPERATIONCODE) AS OPERATIONCODE,
                                                      CASE
                                                          WHEN p.PROGRESSSTATUS = 0 THEN 'Entered'
                                                          WHEN p.PROGRESSSTATUS = 1 THEN 'Planned'
                                                          WHEN p.PROGRESSSTATUS = 2 THEN 'Progress'
                                                          WHEN p.PROGRESSSTATUS = 3 THEN 'Closed'
                                                      END AS STATUS_OPERATION,
                                                      TRIM(o.OPERATIONGROUPCODE) AS OPERATIONGROUPCODE,
                                                      TRIM(p2.SUBCODE02) || '-' || TRIM(p2.SUBCODE03) AS HANGER,
                                                      TRIM(p2.SUBCODE06) AS SUBCODE06,
                                                      i.SUBCODE05 AS NO_WARNA,
                                                      i.WARNA,
                                                      ROW_NUMBER() OVER (PARTITION BY p.PRODUCTIONORDERCODE, p.PRODUCTIONDEMANDCODE ORDER BY p.STEPNUMBER) AS RN,
                                                      o.ABSUNIQUEID AS ABSUNIQUEID_OPERATION,
                                                      p2.CREATIONDATETIME
                                                  FROM
                                                      PRODUCTIONDEMANDSTEP p
                                                  LEFT JOIN OPERATION o ON o.CODE = p.OPERATIONCODE 
                                                  LEFT JOIN PRODUCTIONDEMAND p2 ON p2.CODE = p.PRODUCTIONDEMANDCODE
                                                  LEFT JOIN ITXVIEWCOLOR i ON i.ITEMTYPECODE = p2.ITEMTYPEAFICODE
                                                                          AND i.SUBCODE01 = p2.SUBCODE01
                                                                          AND i.SUBCODE02 = p2.SUBCODE02
                                                                          AND i.SUBCODE03 = p2.SUBCODE03
                                                                          AND i.SUBCODE04 = p2.SUBCODE04
                                                                          AND i.SUBCODE05 = p2.SUBCODE05
                                                                          AND i.SUBCODE06 = p2.SUBCODE06
                                                                          AND i.SUBCODE07 = p2.SUBCODE07
                                                                          AND i.SUBCODE08 = p2.SUBCODE08
                                                                          AND i.SUBCODE09 = p2.SUBCODE09
                                                                          AND i.SUBCODE10 = p2.SUBCODE10
                                                  WHERE 
                                                      TRIM(p.PROGRESSSTATUS) IN ('2', '0')
                                                      AND p.PRODUCTIONDEMANDCODE = '$rowd[nodemand]'
                                                      AND p2.CREATIONDATETIME >= '2023-11-01'
                                                      AND NOT p.PRODUCTIONORDERCODE IS NULL
                                                      AND (TRIM(p2.DESTINATIONORDER) = '1' OR NOT p2.PROJECTCODE IS NULL)
                                                      )
                                              LEFT JOIN ADSTORAGE a ON a.UNIQUEID = ABSUNIQUEID_OPERATION AND a.FIELDNAME = 'Gerobak'
                                              WHERE
                                                  RN = 1
                                                  AND NOT OPERATIONCODE = 'BAT1'
                                                  AND TRIM(OPERATIONGROUPCODE) = 'DYE'
                                                  AND (a.VALUEBOOLEAN IS NULL OR a.VALUEBOOLEAN = 0)
                                              GROUP BY 
                                                  PRODUCTIONORDERCODE,
                                                  STEPNUMBER,
                                                  OPERATIONCODE,
                                                  STATUS_OPERATION,
                                                  HANGER,
                                                  NO_WARNA,
                                                  WARNA,
                                                  SUBCODE06,
                                                  OPERATIONGROUPCODE,
                                                  ABSUNIQUEID_OPERATION,
                                                  CREATIONDATETIME
                                              ORDER BY 
                                                OPERATIONGROUPCODE ASC");
            $row_iptip = db2_fetch_assoc($q_iptip);
            $gerobak = null;
            $jmlgerobak = null;
            if($row_iptip){
              $q_posisikk     = db2_exec($conn2, "SELECT DISTINCT
                                                        p.STEPNUMBER AS STEPNUMBER,
                                                        CASE
                                                            WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) IS NULL OR TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE)
                                                            ELSE TRIM(p.PRODRESERVATIONLINKGROUPCODE)
                                                        END AS OPERATIONCODE,
                                                        TRIM(o.OPERATIONGROUPCODE) AS DEPT,
                                                        o.LONGDESCRIPTION,
                                                        CASE
                                                            WHEN p.PROGRESSSTATUS = 0 THEN 'Entered'
                                                            WHEN p.PROGRESSSTATUS = 1 THEN 'Planned'
                                                            WHEN p.PROGRESSSTATUS = 2 THEN 'Progress'
                                                            WHEN p.PROGRESSSTATUS = 3 THEN 'Closed'
                                                        END AS STATUS_OPERATION,
                                                        iptip.MULAI,
                                                        CASE
                                                            WHEN p.PROGRESSSTATUS = 3 THEN COALESCE(iptop.SELESAI, SUBSTRING(p.LASTUPDATEDATETIME, 1, 19) || '(Run Manual Closures)')
                                                            ELSE iptop.SELESAI
                                                        END AS SELESAI,
                                                        p.PRODUCTIONORDERCODE,
                                                        p.PRODUCTIONDEMANDCODE,
                                                        iptip.LONGDESCRIPTION AS OP1,
                                                        iptop.LONGDESCRIPTION AS OP2,
                                                        CASE
                                                            WHEN TRIM(p.OPERATIONCODE) = 'DYE2' THEN 'Poly'
                                                            WHEN TRIM(p.OPERATIONCODE) = 'DYE4' THEN 'Cotton'
                                                            ELSE LISTAGG(DISTINCT FLOOR(idqd.VALUEQUANTITY), ', ')
                                                        END AS GEROBAK
                                                    FROM 
                                                        PRODUCTIONDEMANDSTEP p 
                                                    LEFT JOIN OPERATION o ON o.CODE = p.OPERATIONCODE 
                                                    LEFT JOIN ADSTORAGE a ON a.UNIQUEID = o.ABSUNIQUEID AND a.FIELDNAME = 'Gerobak'
                                                    LEFT JOIN ITXVIEW_POSISIKK_TGL_IN_PRODORDER iptip ON iptip.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptip.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
                                                    LEFT JOIN ITXVIEW_POSISIKK_TGL_OUT_PRODORDER iptop ON iptop.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptop.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
                                                    LEFT JOIN ITXVIEW_DETAIL_QA_DATA idqd ON idqd.PRODUCTIONDEMANDCODE = p.PRODUCTIONDEMANDCODE AND idqd.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE
                                                                                        AND idqd.OPERATIONCODE = CASE
                                                                                                                    WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) IS NULL OR TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE)
                                                                                                                    ELSE TRIM(p.PRODRESERVATIONLINKGROUPCODE)
                                                                                                                END
                                                                                        AND (idqd.VALUEINT = p.STEPNUMBER OR idqd.VALUEINT = p.GROUPSTEPNUMBER) 
                                                                                        AND (idqd.CHARACTERISTICCODE = 'GRB1' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB2' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB3' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB4' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB5' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB6' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB7' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB8')
                                                                                        AND NOT (idqd.VALUEQUANTITY = 9 OR idqd.VALUEQUANTITY = 999 OR idqd.VALUEQUANTITY = 1 OR idqd.VALUEQUANTITY = 9999 OR idqd.VALUEQUANTITY = 99999 OR idqd.VALUEQUANTITY = 99 OR idqd.VALUEQUANTITY = 91)
                                                    WHERE
                                                        p.PRODUCTIONORDERCODE  = '$row_iptip[PRODUCTIONORDERCODE]' 
                                                        AND p.PRODUCTIONDEMANDCODE IN ($row_iptip[PRODUCTIONDEMANDCODE2])
                                                        AND p.STEPNUMBER < '$row_iptip[STEPNUMBER]'
                                                        AND NOT idqd.VALUEQUANTITY IS NULL
                                                        AND (a.VALUEBOOLEAN IS NULL OR a.VALUEBOOLEAN = 0)
                                                    GROUP BY
                                                        p.PRODUCTIONORDERCODE,
                                                        p.STEPNUMBER,
                                                        p.OPERATIONCODE,
                                                        p.PRODRESERVATIONLINKGROUPCODE,
                                                        o.OPERATIONGROUPCODE,
                                                        o.LONGDESCRIPTION,
                                                        p.PROGRESSSTATUS,
                                                        iptip.MULAI,
                                                        iptop.SELESAI,
                                                        p.LASTUPDATEDATETIME,
                                                        p.PRODUCTIONORDERCODE,
                                                        p.PRODUCTIONDEMANDCODE,
                                                        iptip.LONGDESCRIPTION,
                                                        iptop.LONGDESCRIPTION
                                                    ORDER BY 
                                                        p.STEPNUMBER
                                                    DESC
                                                    LIMIT 1");
                                                    
              $row_posisikk   = db2_fetch_assoc($q_posisikk);
              $gerobak        = $row_posisikk['GEROBAK'];


              $count_gerobak      = db2_exec($conn2, "SELECT 
                                                      COUNT(DISTINCT idqd.VALUEQUANTITY) AS JML_GEROBAK
                                                    FROM 
                                                        PRODUCTIONDEMANDSTEP p 
                                                    LEFT JOIN OPERATION o ON o.CODE = p.OPERATIONCODE 
                                                    -- LEFT JOIN ADSTORAGE a ON a.UNIQUEID = o.ABSUNIQUEID AND a.FIELDNAME = 'Gerobak'
                                                    LEFT JOIN ITXVIEW_POSISIKK_TGL_IN_PRODORDER iptip ON iptip.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptip.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
                                                    LEFT JOIN ITXVIEW_POSISIKK_TGL_OUT_PRODORDER iptop ON iptop.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptop.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
                                                    LEFT JOIN ITXVIEW_DETAIL_QA_DATA idqd ON idqd.PRODUCTIONDEMANDCODE = p.PRODUCTIONDEMANDCODE AND idqd.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE
                                                                                        AND idqd.OPERATIONCODE = CASE
                                                                                                                    WHEN TRIM(p.PRODRESERVATIONLINKGROUPCODE) IS NULL OR TRIM(p.PRODRESERVATIONLINKGROUPCODE) = '' THEN TRIM(p.OPERATIONCODE)
                                                                                                                    ELSE TRIM(p.PRODRESERVATIONLINKGROUPCODE)
                                                                                                                END
                                                                                        AND (idqd.VALUEINT = p.STEPNUMBER OR idqd.VALUEINT = p.GROUPSTEPNUMBER) 
                                                                                        AND (idqd.CHARACTERISTICCODE = 'GRB1' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB2' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB3' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB4' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB5' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB6' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB7' OR
                                                                                            idqd.CHARACTERISTICCODE = 'GRB8')
                                                                                        AND NOT (idqd.VALUEQUANTITY = 9 OR idqd.VALUEQUANTITY = 999 OR idqd.VALUEQUANTITY = 1 OR idqd.VALUEQUANTITY = 9999 OR idqd.VALUEQUANTITY = 99999 OR idqd.VALUEQUANTITY = 99 OR idqd.VALUEQUANTITY = 91)
                                                    WHERE
                                                        p.PRODUCTIONORDERCODE  = '$row_iptip[PRODUCTIONORDERCODE]' 
                                                        AND p.PRODUCTIONDEMANDCODE IN ($row_iptip[PRODUCTIONDEMANDCODE2])
                                                        AND p.STEPNUMBER < '$row_iptip[STEPNUMBER]'
                                                        AND NOT idqd.VALUEQUANTITY IS NULL
                                                        -- AND (a.VALUEBOOLEAN IS NULL OR a.VALUEBOOLEAN = 0)
                                                    GROUP BY
                                                        p.PRODUCTIONORDERCODE,
                                                        p.STEPNUMBER,
                                                        p.OPERATIONCODE,
                                                        p.PRODRESERVATIONLINKGROUPCODE,
                                                        o.OPERATIONGROUPCODE,
                                                        o.LONGDESCRIPTION,
                                                        p.PROGRESSSTATUS,
                                                        iptip.MULAI,
                                                        iptop.SELESAI,
                                                        p.LASTUPDATEDATETIME,
                                                        p.PRODUCTIONORDERCODE,
                                                        p.PRODUCTIONDEMANDCODE,
                                                        iptip.LONGDESCRIPTION,
                                                        iptop.LONGDESCRIPTION
                                                    ORDER BY 
                                                        p.STEPNUMBER
                                                    DESC
                                                    LIMIT 1");
              $row_count_gerobak  = db2_fetch_assoc($count_gerobak);
              $jmlgerobak         = $row_count_gerobak['JML_GEROBAK'];
            }
          ?>
        <!-- pencarian gerobak -->
        <td valign="top">
          <?= $gerobak; ?>
        </td>
        <td valign="top">
          <?= $jmlgerobak; ?>
        </td>
      </tr>
    <?php
      $totrol += $rowd['rol'];
      $totberat += $rowd['bruto'];
      $no++;
    } ?>
    <tr>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <th bgcolor="#99FF99">Total</th>
      <td bgcolor="#99FF99">&nbsp;</td>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99"><?php echo $totrol; ?></th>
      <th bgcolor="#99FF99"><?php echo $totberat; ?></th>
      <th bgcolor="#99FF99">&nbsp;</th>
    </tr>
  </table>
</body>
