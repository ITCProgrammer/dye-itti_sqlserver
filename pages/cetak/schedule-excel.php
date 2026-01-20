<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=report-schedule-produksi-".substr($_GET['awal'],0,10).".xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../tgl_indo.php";

$idkk = $_REQUEST['idkk'];
$act = $_GET['g'];

$qTgl = sqlsrv_query(
  $con,
  "SELECT
     CONVERT(varchar(16), GETDATE(), 120) AS tgl_skrg,
     CONVERT(varchar(16), DATEADD(DAY, 1, GETDATE()), 120) AS tgl_besok"
);
$rTgl = sqlsrv_fetch_array($qTgl, SQLSRV_FETCH_ASSOC);

$Awal   = $_GET['awal'];
$Akhir  = $_GET['akhir'];

if ($Awal == $Akhir) {
  $TglPAl   = substr($Awal, 0, 10);
  $TglPAr   = substr($Akhir, 0, 10);
} else {
  $TglPAl   = $Awal;
  $TglPAr   = $Akhir;
}

$shft = $_GET['shft'];

function cekDesimal($angka)
{
  $bulat  = round($angka);
  if ($bulat > $angka) {
    $jam = $bulat - 1;
    $waktu = $jam . " Jam 30 Menit";
  } else {
    $jam = $bulat;
    $waktu = $jam . " Jam 00 Menit";
  }
  return $waktu;
}

function convertToTime($decimalTime) {
    // Pecah nilai desimal menjadi jam dan menit
    $hours = floor($decimalTime); // Ambil bagian jam
    $minutes = round(($decimalTime - $hours) * 100); // Ambil bagian menit
    // Format ke dalam HH:MM
    return sprintf('%02d:%02d', $hours, $minutes);
}

function calculateTimeDifference($time1, $time2) {
  // Konversi waktu ke menit
  $toMinutes = function($time) {
      [$hours, $minutes] = explode(':', $time);
      return $hours * 60 + $minutes;
  };

  $diff = $toMinutes($time1) - $toMinutes($time2);

  // Tentukan tanda
  $sign = $diff < 0 ? '-' : '';
  $absDiff = abs($diff);

  // Format jam dan menit
  $hours = str_pad(floor($absDiff / 60), 2, '0', STR_PAD_LEFT);
  $minutes = str_pad($absDiff % 60, 2, '0', STR_PAD_LEFT);

  return "{$sign}{$hours}:{$minutes}";
}

function normalizeIsoDateTime($value) {
  $value = trim((string)$value);
  if ($value === '') {
    return '';
  }
  $value = str_replace(' ', 'T', $value);
  if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
    return $value . 'T00:00:00';
  }
  if (preg_match('/^(\d{4}-\d{2}-\d{2})T(\d{1,2})$/', $value, $m)) {
    return $m[1] . 'T' . str_pad($m[2], 2, '0', STR_PAD_LEFT) . ':00:00';
  }
  if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{1,2}:\d{2}$/', $value)) {
    return $value . ':00';
  }
  return $value;
}

function formatSqlsrvDateTime($value, $format = 'Y-m-d H:i:s') {
  if ($value instanceof DateTimeInterface) {
    return $value->format($format);
  }
  if ($value === null) {
    return '';
  }
  return (string)$value;
}
?>

<body>

  <strong>Periode: <?php echo $TglPAl; ?> s/d <?php echo $TglPAr; ?></strong><br>
  <strong>Shift: <?php echo $shft; ?></strong><br />
  <table width="100%" border="1">
    <tr>
      <th bgcolor="#99FF99">NO.</th>
      <th bgcolor="#99FF99">NO MC</th>
      <th bgcolor="#99FF99">SHIFT</th>
      <th bgcolor="#99FF99">NOKK</th>
      <th bgcolor="#99FF99">KAPASITAS</th>
      <th bgcolor="#99FF99">LANGGANAN</th>
      <th bgcolor="#99FF99">BUYER</th>
      <th bgcolor="#99FF99">NO PO</th>
      <th bgcolor="#99FF99">NO ORDER</th>
      <th bgcolor="#99FF99">JENIS KAIN</th>
      <th bgcolor="#99FF99">WARNA</th>
      <th bgcolor="#99FF99">NO WARNA</th>
      <th bgcolor="#99FF99">LOT</th>
      <th bgcolor="#99FF99">ROLL</th>
      <th bgcolor="#99FF99">QUANTITY</th>
      <th bgcolor="#99FF99">LOADING</th>
      <th bgcolor="#99FF99">PROSES</th>
      <th bgcolor="#99FF99">TARGET PROSES</th>
      <th bgcolor="#99FF99">LAMA PROSES</th>
      <th bgcolor="#99FF99">LAMA STOP</th>
      <th bgcolor="#99FF99">OVER TIME</th>
      <th bgcolor="#99FF99">K.R</th>
      <th bgcolor="#99FF99">R.B/R.L</th>
      <th bgcolor="#99FF99">Jumlah Stop Proses</th>
      <th bgcolor="#99FF99">Total Jam Stop Proses</th>
      <th bgcolor="#99FF99">Alasan Stop Proses</th>
      <th bgcolor="#99FF99">Tgl Stop 1</th>
      <th bgcolor="#99FF99">Tgl Mulai 1</th>
      <th bgcolor="#99FF99">Tgl Stop 2</th>
      <th bgcolor="#99FF99">Tgl Mulai 2</th>
      <th bgcolor="#99FF99">Tgl Stop 3</th>
      <th bgcolor="#99FF99">Tgl Mulai 3</th>
      <th bgcolor="#99FF99">Tgl Stop 4</th>
      <th bgcolor="#99FF99">Tgl Mulai 4</th>
    </tr>
    <?php
      $Awal = $_GET['awal'];
      $Akhir = $_GET['akhir'];
      $Tgl = substr($Awal, 0, 10);
      $AwalIso = normalizeIsoDateTime($Awal);
      $AkhirIso = normalizeIsoDateTime($Akhir);

      if ($Awal != $Akhir) {
        $Where = " ca_dt.dt_update BETWEEN TRY_CONVERT(datetime, '$AwalIso') AND TRY_CONVERT(datetime, '$AkhirIso') ";
      } else {
        $Where = " CONVERT(date, ca_dt.dt_update) = CONVERT(date, '$Tgl') ";
      }

      if ($_GET['shft'] == "ALL") {
        $shft = " ";
      } else {
        $shft = " ISNULL(hc.g_shift, sch.g_shift)='$_GET[shft]' AND ";
      }
      $sql = sqlsrv_query($con, "SELECT
                x.*,
                m.no_mesin AS mc
              FROM
                db_dying.tbl_mesin m
              LEFT JOIN(
              SELECT
              hc.kd_stop, hc.mulai_stop, hc.selesai_stop, hc.ket,
              ca_proses_lib.proses_hhmm AS lama_proses,
              hc.[STATUS] AS sts_hasil,
              ca_proses_any.jam AS jam, ca_proses_any.menit AS menit,
              hc.POINT,
              CONVERT(char(10), ca_dt.dt_mulai_stop, 23) AS t_mulai,
              CONVERT(char(10), ca_dt.dt_selesai_stop, 23) AS t_selesai,
              CONVERT(char(5), ca_dt.dt_mulai_stop, 108) AS j_mulai,
              CONVERT(char(5), ca_dt.dt_selesai_stop, 108) AS j_selesai,
              DATEDIFF(MINUTE, ca_dt.dt_mulai_stop, ca_dt.dt_selesai_stop) AS lama_stop_menit,
              hc.acc_keluar, hc.analisa, hc.k_resep,
              sch.proses, sch.buyer, sch.langganan, sch.no_order, sch.jenis_kain, sch.no_mesin, sch.warna, sch.lot, sch.energi, sch.dyestuff, sch.ket_status, sch.kapasitas, sch.loading, sch.resep, sch.kategori_warna,
              mt.l_r, mt.rol, mt.bruto, mt.pakai_air,
              CONVERT(char(10), ca_dt.dt_mt_buat, 23) AS tgl_in,
              CONVERT(char(10), ca_dt.dt_hc_buat, 23) AS tgl_out,
              CONVERT(char(5), ca_dt.dt_mt_buat, 108) AS jam_in,
              CONVERT(char(5), ca_dt.dt_hc_buat, 108) AS jam_out,
              CASE WHEN hc.g_shift IS NULL THEN sch.g_shift ELSE hc.g_shift END AS shft,
              hc.operator_keluar,
              sch.nokk, sch.no_warna, sch.lebar, sch.gramasi,
              mt.carry_over,
              sch.no_hanger, sch.no_item, sch.po, sch.tgl_delivery, sch.target,
              ca_overtime.overtime_hhmm AS overtime,
              CASE WHEN ca_base.base_jam_dec>TRY_CONVERT(decimal(18, 2), sch.target) THEN 'lebih' ELSE 'kurang' END AS jjm,
              mt.ket_stopmesin, mt.ket_stopmesin2, mt.ket_stopmesin3, mt.ket_stopmesin4,
              mt.tgl_stop, mt.tgl_stop2, mt.tgl_stop3, mt.tgl_stop4,
              mt.tgl_mulai, mt.tgl_mulai2, mt.tgl_mulai3, mt.tgl_mulai4,
              CASE WHEN ca_dt.dt_tgl_stop1 IS NULL THEN 0 ELSE 1 END AS tgl_stop_value,
              CASE WHEN ca_dt.dt_tgl_stop2 IS NULL THEN 0 ELSE 1 END AS tgl_stop2_value,
              CASE WHEN ca_dt.dt_tgl_stop3 IS NULL THEN 0 ELSE 1 END AS tgl_stop3_value,
              CASE WHEN ca_dt.dt_tgl_stop4 IS NULL THEN 0 ELSE 1 END AS tgl_stop4_value,
              ca_totalstop.total_stop_mesin
              FROM db_dying.tbl_schedule sch
              LEFT JOIN db_dying.tbl_montemp mt ON mt.id_schedule = sch.id
              LEFT JOIN db_dying.tbl_hasilcelup hc ON hc.id_montemp = mt.id
              CROSS APPLY(
              SELECT
              dt_update = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_update AS varchar(30)), '')),
              dt_mt_buat = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_buat AS varchar(30)), '')),
              dt_hc_buat = TRY_CONVERT(datetime, NULLIF(CAST(hc.tgl_buat AS varchar(30)), '')),
              dt_mulai_stop = TRY_CONVERT(datetime, NULLIF(CAST(hc.mulai_stop AS varchar(30)), '')),
              dt_selesai_stop = TRY_CONVERT(datetime, NULLIF(CAST(hc.selesai_stop AS varchar(30)), '')),
              dt_tgl_stop1 = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_stop AS varchar(30)), '')),
              dt_tgl_mulai1 = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_mulai AS varchar(30)), '')),
              dt_tgl_stop2 = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_stop2 AS varchar(30)), '')),
              dt_tgl_mulai2 = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_mulai2 AS varchar(30)), '')),
              dt_tgl_stop3 = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_stop3 AS varchar(30)), '')),
              dt_tgl_mulai3 = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_mulai3 AS varchar(30)), '')),
              dt_tgl_stop4 = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_stop4 AS varchar(30)), '')),
              dt_tgl_mulai4 = TRY_CONVERT(datetime, NULLIF(CAST(mt.tgl_mulai4 AS varchar(30)), '')),
              lama_raw = NULLIF(LTRIM(RTRIM(CAST(hc.lama_proses AS varchar(20)))), '')) ca_dt
              CROSS APPLY(
              SELECT
              lama_h = CASE
                WHEN ca_dt.lama_raw IS NULL THEN NULL
                WHEN CHARINDEX(':', ca_dt.lama_raw) > 0 THEN TRY_CONVERT(int, LEFT(ca_dt.lama_raw, CHARINDEX(':', ca_dt.lama_raw) - 1))
                ELSE TRY_CONVERT(int, ca_dt.lama_raw)
              END,
              lama_m = CASE
                WHEN ca_dt.lama_raw IS NULL THEN NULL
                WHEN CHARINDEX(':', ca_dt.lama_raw) > 0 THEN TRY_CONVERT(int, RIGHT(ca_dt.lama_raw, 2))
                ELSE 0
              END) ca_lama
              CROSS APPLY(
              SELECT
              base_minutes = CASE
                WHEN ca_lama.lama_h IS NULL OR ca_lama.lama_m IS NULL THEN NULL
                ELSE ca_lama.lama_h * 60 + ca_lama.lama_m
              END,
              stop_minutes = CASE WHEN ca_dt.dt_tgl_mulai1 IS NULL OR ca_dt.dt_tgl_stop1 IS NULL THEN NULL ELSE DATEDIFF(MINUTE, ca_dt.dt_tgl_stop1, ca_dt.dt_tgl_mulai1) END) ca0
              CROSS APPLY(
              SELECT proses_minutes = CASE
                WHEN ca0.base_minutes IS NULL THEN NULL
                WHEN ca0.stop_minutes IS NOT NULL THEN ca0.base_minutes-ca0.stop_minutes
                ELSE ca0.base_minutes END) ca1_any
              CROSS APPLY(
              SELECT proses_h =(ca1_any.proses_minutes / 60), proses_m =(ABS(ca1_any.proses_minutes)%60)) ca2_any
              CROSS APPLY(
              SELECT
              hh = REPLICATE('0', CASE WHEN LEN(CAST(ABS(ca2_any.proses_h) AS varchar(20)))>= 2 THEN 0 ELSE 2-LEN(CAST(ABS(ca2_any.proses_h) AS varchar(20))) END)+ CAST(ABS(ca2_any.proses_h) AS varchar(20)),
              mm = REPLICATE('0', CASE WHEN LEN(CAST(ca2_any.proses_m AS varchar(20)))>= 2 THEN 0 ELSE 2-LEN(CAST(ca2_any.proses_m AS varchar(20))) END)+ CAST(ca2_any.proses_m AS varchar(20))) ca3_any
              CROSS APPLY(
              SELECT proses_hhmm = ca3_any.hh + ':' + ca3_any.mm, jam = ca3_any.hh, menit = ca3_any.mm) ca_proses_any
              CROSS APPLY(
              SELECT proses_minutes = CASE
                WHEN ca0.base_minutes IS NULL THEN NULL
                WHEN mt.ket_stopmesin = 'LIBUR' AND ca0.stop_minutes IS NOT NULL THEN ca0.base_minutes-ca0.stop_minutes
                ELSE ca0.base_minutes END) ca1_lib
              CROSS APPLY(
              SELECT proses_h =(ca1_lib.proses_minutes / 60), proses_m =(ABS(ca1_lib.proses_minutes)%60)) ca2_lib
              CROSS APPLY(
              SELECT
              hh = REPLICATE('0', CASE WHEN LEN(CAST(ABS(ca2_lib.proses_h) AS varchar(20)))>= 2 THEN 0 ELSE 2-LEN(CAST(ABS(ca2_lib.proses_h) AS varchar(20))) END)+ CAST(ABS(ca2_lib.proses_h) AS varchar(20)),
              mm = REPLICATE('0', CASE WHEN LEN(CAST(ca2_lib.proses_m AS varchar(20)))>= 2 THEN 0 ELSE 2-LEN(CAST(ca2_lib.proses_m AS varchar(20))) END)+ CAST(ca2_lib.proses_m AS varchar(20))) ca3_lib
              CROSS APPLY(
              SELECT proses_hhmm = ca3_lib.hh + ':' + ca3_lib.mm,
              proses_jam_dec = CASE
                WHEN ca1_lib.proses_minutes IS NULL THEN NULL
                ELSE (ABS(ca2_lib.proses_h)+ ROUND(CAST(ca2_lib.proses_m AS decimal(18, 2))/ 60.0, 2))
              END) ca_proses_lib
              CROSS APPLY(
              SELECT base_jam_dec = CASE
                WHEN ca0.base_minutes IS NULL THEN NULL
                ELSE (ABS(ca_lama.lama_h)+ ROUND(CAST(ca_lama.lama_m AS decimal(18, 2))/ 60.0, 2))
              END) ca_base
              CROSS APPLY(
              SELECT target_h = TRY_CONVERT(int, PARSENAME(sch.target, 2)), target_m = TRY_CONVERT(int, PARSENAME(sch.target, 1))) cat0
              CROSS APPLY(
              SELECT target_minutes =(COALESCE(cat0.target_h, 0)* 60)+ COALESCE(cat0.target_m, 0),
              lama_minutes = ca0.base_minutes) cat1
              CROSS APPLY(
              SELECT diff_minutes =(cat1.lama_minutes-cat1.target_minutes)) cat2
              CROSS APPLY(
              SELECT ov_h =(ABS(cat2.diff_minutes)/ 60), ov_m =(ABS(cat2.diff_minutes)%60), ov_sign = CASE WHEN cat2.diff_minutes<0 THEN '-' ELSE '' END) cat3
              CROSS APPLY(
              SELECT overtime_hhmm = cat3.ov_sign
              + REPLICATE('0', CASE WHEN LEN(CAST(cat3.ov_h AS varchar(20)))>= 2 THEN 0 ELSE 2-LEN(CAST(cat3.ov_h AS varchar(20))) END)+ CAST(cat3.ov_h AS varchar(20))
              + ':'
              + REPLICATE('0', CASE WHEN LEN(CAST(cat3.ov_m AS varchar(20)))>= 2 THEN 0 ELSE 2-LEN(CAST(cat3.ov_m AS varchar(20))) END)+ CAST(cat3.ov_m AS varchar(20))) ca_overtime
              CROSS APPLY(
              SELECT total_stop_seconds =
              COALESCE(CASE WHEN ca_dt.dt_tgl_stop1 IS NULL OR ca_dt.dt_tgl_mulai1 IS NULL THEN 0 ELSE DATEDIFF(SECOND, ca_dt.dt_tgl_stop1, ca_dt.dt_tgl_mulai1) END, 0)
              + COALESCE(CASE WHEN ca_dt.dt_tgl_stop2 IS NULL OR ca_dt.dt_tgl_mulai2 IS NULL THEN 0 ELSE DATEDIFF(SECOND, ca_dt.dt_tgl_stop2, ca_dt.dt_tgl_mulai2) END, 0)
              + COALESCE(CASE WHEN ca_dt.dt_tgl_stop3 IS NULL OR ca_dt.dt_tgl_mulai3 IS NULL THEN 0 ELSE DATEDIFF(SECOND, ca_dt.dt_tgl_stop3, ca_dt.dt_tgl_mulai3) END, 0)
              + COALESCE(CASE WHEN ca_dt.dt_tgl_stop4 IS NULL OR ca_dt.dt_tgl_mulai4 IS NULL THEN 0 ELSE DATEDIFF(SECOND, ca_dt.dt_tgl_stop4, ca_dt.dt_tgl_mulai4) END, 0)) ts0
              CROSS APPLY(
              SELECT th =(ts0.total_stop_seconds / 3600), tm =((ts0.total_stop_seconds%3600)/ 60)) ts1
              CROSS APPLY(
              SELECT
              thh = REPLICATE('0', CASE WHEN LEN(CAST(ts1.th AS varchar(20)))>= 2 THEN 0 ELSE 2-LEN(CAST(ts1.th AS varchar(20))) END)+ CAST(ts1.th AS varchar(20)),
              tmm = REPLICATE('0', CASE WHEN LEN(CAST(ts1.tm AS varchar(20)))>= 2 THEN 0 ELSE 2-LEN(CAST(ts1.tm AS varchar(20))) END)+ CAST(ts1.tm AS varchar(20))) ts2
              CROSS APPLY(
              SELECT total_stop_mesin = ts2.thh + ':' + ts2.tmm) ca_totalstop
              WHERE $shft $Where
              ) x ON
                (m.no_mesin = x.no_mesin OR m.no_mc_lama = x.no_mesin)
              ORDER BY
                m.no_mesin
              ");
        $no = 1;
        $totrol = 0;
        $totberat = 0;
        $c = 0;

      if ($sql === false) {
        $err = sqlsrv_errors();
        $msg = $err ? $err[0]['message'] : 'Gagal mengambil data schedule.';
        echo '<tr><td colspan="34">Error SQL: ' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</td></tr>';
      } else {
      while ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $target = explode(".", $rowd['target']);
        $jamtarget = (int)$target[0] * 60;
        if ($target[1] == '5') {
          $menittarget = 30;
        } else {
          $menittarget = 0;
        }
        $jmltarget = $jamtarget + $menittarget;
        $jamproses = (int)$rowd['jam'] * 60;
        $jmlproses = $jamproses + (int)$rowd['menit'];
        $overtime = $jmlproses - $jmltarget;
        $hours = floor($overtime / 60);
        $min = $overtime - ($hours * 60);
    ?>
      <tr valign="top">
        <td><?php echo $no; ?></td>
        <td>'<?php echo $rowd['mc']; ?></td>
        <td><?php echo $rowd['shft']; ?></td>
        <td>'<?php echo $rowd['nokk']; ?></td>
        <td><?php echo $rowd['kapasitas']; ?></td>
        <td><?php echo $rowd['langganan']; ?></td>
        <td><?php echo $rowd['buyer']; ?></td>
        <td><?php echo $rowd['po']; ?></td>
        <td><?php echo $rowd['no_order']; ?></td>
        <td><?php echo $rowd['jenis_kain']; ?></td>
        <td><?php echo $rowd['warna']; ?></td>
        <td><?php echo $rowd['no_warna']; ?></td>
        <td>'<?php echo $rowd['lot']; ?></td>
        <td align="right">
          <?php 
            if ($rowd['tgl_out'] != "") {
              $rol = $rowd['rol'];
            } else {
              $rol = 0;
            }
            echo $rol; 
          ?>
          </td>
        <td align="right">
          <?php 
            if ($rowd['tgl_out'] != "") {
              $brt = $rowd['bruto'];
            } else {
              $brt = 0;
            }
            echo $brt; 
          ?>
        </td>
        <td><?php echo $rowd['loading']; ?></td>
        <td><?php echo $rowd['proses']; ?></td>
        <!-- <td><?php echo cekDesimal($rowd['target']); ?></td> -->
        <td><?= convertToTime($rowd['target']); ?></td> <!-- TARGET PROSES -->
        <?php 
          $lamaProses   = $rowd['lama_proses'] ?? null;
          $targetProses = isset($rowd['target']) ? convertToTime($rowd['target']) : null;

          if($lamaProses && $targetProses){
            $overtime = ($lamaProses && $targetProses) ? calculateTimeDifference($lamaProses, $targetProses) : '';
          }else{
            $overtime = '';
          }
        ?>
        <td bgcolor="<?php if ($overtime > '02:00:00') { echo "yellow"; } ?>">
          <?php 
            echo $rowd['lama_proses'];
          ?>
          <br>
          <?php echo $rowd['sts_hasil']; ?>
        </td><!-- LAMA PROSES -->
        <td bgcolor="<?php if ($overtime > '02:00:00') { echo "yellow"; } ?>">
          <?php echo $rowd['analisa']; ?>
          <br>
          <?php 
            if ($rowd['lama_stop_menit'] != "") {
              $jam = floor(round($rowd['lama_stop_menit']) / 60);
              $menit = round($rowd['lama_stop_menit']) % 60;
              echo $jam . " Jam " . $menit . " Menit";
            }
          ?>
        </td>
        <td><?= $overtime; ?></td><!-- OVERTIME -->
        <td><?php echo $rowd['k_resep']; ?></td>
        <td>
          <?php 
            if ($rowd['ket_status'] == "") {
              echo "";
            } else if ($rowd['ket_status'] != "MC Stop") {
              if ($rowd['resep'] == "Baru") {
                echo "R.B";
              } else {
                echo "R.L";
              }
            } 
          ?>
        </td>
        <td><?= $rowd['tgl_stop_value']+$rowd['tgl_stop2_value']+$rowd['tgl_stop3_value']+$rowd['tgl_stop4_value']; ?></td><!-- Jumlah Stop Proses -->
        <td><?= $rowd['total_stop_mesin']; ?></td><!-- Total Jam Stop Proses -->
        <?php
          $labelTglMulai = '';
          $tglStop1 = formatSqlsrvDateTime($rowd['tgl_stop']);
          $tglStop2 = formatSqlsrvDateTime($rowd['tgl_stop2']);
          $tglStop3 = formatSqlsrvDateTime($rowd['tgl_stop3']);
          $tglStop4 = formatSqlsrvDateTime($rowd['tgl_stop4']);
          $tglMulai1 = formatSqlsrvDateTime($rowd['tgl_mulai']);
          $tglMulai2 = formatSqlsrvDateTime($rowd['tgl_mulai2']);
          $tglMulai3 = formatSqlsrvDateTime($rowd['tgl_mulai3']);
          $tglMulai4 = formatSqlsrvDateTime($rowd['tgl_mulai4']);

          if ($tglStop1 === '0000-00-00 00:00:00' || $tglStop1 === '') {
            $tglstop = null;
          }else{
            $tglstop = $tglStop1;
          }
          if ($tglStop2 === '0000-00-00 00:00:00' || $tglStop2 === '') {
            $tglstop2 = null;
          }else{
            $tglstop2 = $tglStop2;
          }
          if ($tglStop3 === '0000-00-00 00:00:00' || $tglStop3 === '') {
            $tglstop3 = null;
          }else{
            $tglstop3 = $tglStop3;
          }
          if ($tglStop4 === '0000-00-00 00:00:00' || $tglStop4 === '') {
            $tglstop4 = null;
          }else{
            $tglstop4 = $tglStop4;
          }
          
          if($tglstop && $tglMulai1 === ''){
            $labelTglMulai = "Red";
          }
          if($tglstop2 && $tglMulai2 === ''){
            $labelTglMulai = "Red";
          }
          if($tglstop3 && $tglMulai3 === ''){
            $labelTglMulai = "Red";
          }
          if($tglstop4 && $tglMulai4 === ''){
            $labelTglMulai = "Red";
          }
        ?>
        <td bgcolor="<?= $labelTglMulai; ?>"><?= $rowd['ket_stopmesin'].' - '.$rowd['ket_stopmesin2'].' - '.$rowd['ket_stopmesin3'].' - '.$rowd['ket_stopmesin4']; ?></td><!-- Alasan Stop Proses -->
        <td><?= $tglStop1; ?></td> <!-- Tgl Stop 1 -->
        <td><?= $tglMulai1; ?></td> <!-- Tgl Mulai 1 -->

        <td><?= $tglStop2; ?></td> <!-- Tgl Stop 2 -->
        <td><?= $tglMulai2; ?></td> <!-- Tgl Mulai 2 -->

        <td><?= $tglStop3; ?></td> <!-- Tgl Stop 3 -->
        <td><?= $tglMulai3; ?></td> <!-- Tgl Mulai 3 -->

        <td><?= $tglStop4; ?></td> <!-- Tgl Stop 4 -->
        <td><?= $tglMulai4; ?></td> <!-- Tgl Mulai 4 -->
        </th>
      </tr>
    <?php
        $totrol = $totrol + $rol;
        $totberat = $totberat + $brt;
        $no++;
      }
      }
    ?>
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
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <th bgcolor="#99FF99">Total</th>
      <td bgcolor="#99FF99">&nbsp;</td>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99"><?php echo $totrol; ?></th>
      <th bgcolor="#99FF99"><?php echo $totberat; ?></th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
  </table>
</body>
