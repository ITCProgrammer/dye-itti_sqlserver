<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=report-waktu-proses-" . substr($_GET['awal'], 0, 10) . ".xls"); //ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../koneksiLAB.php";
include "../../tgl_indo.php";
//--
$idkk = isset($_REQUEST['idkk']) ? $_REQUEST['idkk'] : null;
$act  = isset($_GET['g']) ? $_GET['g'] : null;
//- (tidak dipakai di bawah, jadi cukup inisialisasi saja)
$Awal = $_GET['awal'];
$Akhir = $_GET['akhir'];
$shft1 = $_GET['shft'];
?>

<body>
  <strong>Periode: <?php echo $Awal; ?> s/d <?php echo $Akhir; ?></strong><br>
  <strong>Shift: <?php echo $shft1; ?></strong><br />
  <table width="100%" border="1">
    <tr>
      <th rowspan="2" bgcolor="#99FF99">NO.</th>
      <th rowspan="2" bgcolor="#99FF99">SHIFT</th>
      <th rowspan="2" bgcolor="#99FF99">NO MC</th>
      <th rowspan="2" bgcolor="#99FF99">KAPASITAS</th>
      <th rowspan="2" bgcolor="#99FF99">LANGGANAN</th>
      <th rowspan="2" bgcolor="#99FF99">BUYER</th>
      <th rowspan="2" bgcolor="#99FF99">NO ORDER</th>
      <th rowspan="2" bgcolor="#99FF99">JENIS KAIN</th>
      <th rowspan="2" bgcolor="#99FF99">WARNA</th>
      <th rowspan="2" bgcolor="#99FF99">No Warna</th>
      <th rowspan="2" bgcolor="#99FF99">K.W</th>
      <th rowspan="2" bgcolor="#99FF99">LOT</th>
      <th rowspan="2" bgcolor="#99FF99">QTY</th>
      <th rowspan="2" bgcolor="#99FF99">PROSES</th>
      <th rowspan="2" bgcolor="#99FF99">TARGET</th>
      <th rowspan="2" bgcolor="#99FF99">KETERANGAN</th>
      <th rowspan="2" bgcolor="#99FF99">K.R</th>
      <th colspan="2" bgcolor="#99FF99">JAM PROSES</th>
      <th rowspan="2" bgcolor="#99FF99">LAMA PROSES</th>
      <th rowspan="2" bgcolor="#99FF99">TGL MULAI STOP</th>
      <th rowspan="2" bgcolor="#99FF99">TGL SELESAI STOP</th>
      <th rowspan="2" bgcolor="#99FF99">LAMA PROSES STOP</th>
      <th rowspan="2" bgcolor="#99FF99">KETERANGAN STOP MESIN</th>
      <th rowspan="2" bgcolor="#99FF99">POINT</th>
    </tr>
    <tr>
      <th bgcolor="#99FF99">TGL IN</th>
      <th bgcolor="#99FF99">TGL OUT</th>
    </tr>
    <?php
    // Filter shift (SQL Server)
    if ($shft1 == "ALL") {
      $shft = "";
    } else {
      $shft = " AND ISNULL(a.g_shift, b.g_shift) = '" . $shft1 . "'";
    }

    // Query versi SQL Server (mengikuti logika di pages/lap-waktu-proses.php)
    $sql = sqlsrv_query(
      $con,
      "SELECT
          a.no_mesin,
          a.kapasitas,
          b.g_shift,
          b.operator_keluar AS operator,
          a.jenis_kain,
          a.langganan,
          a.buyer,
          a.no_order,
          a.warna,
          a.no_warna,
          a.lot,
          a.proses,
          a.kategori_warna,
          CASE
              WHEN calc.proc_min IS NULL OR calc.stop_min IS NULL
                  THEN calc.base_hhmm
              ELSE
                  CONCAT(
                      RIGHT('00' + CAST((calc.proc_min - calc.stop_min) / 60 AS varchar(2)), 2),
                      ':',
                      RIGHT('00' + CAST(ABS((calc.proc_min - calc.stop_min) % 60) AS varchar(2)), 2)
                  )
          END AS lama,
          b.point,
          b.k_resep,
          CASE
              WHEN a.target < (
                  CASE
                      WHEN calc.proc_min IS NULL THEN NULL
                      WHEN calc.stop_min IS NULL THEN ROUND(calc.proc_min / 60.0, 2)
                      ELSE ROUND((calc.proc_min - calc.stop_min) / 60.0, 2)
                  END
                )
              THEN 'Over'
              ELSE 'OK'
          END AS ket,
          '' AS sts,
          a.target,
          CONVERT(varchar(19), c.tgl_buat, 120) AS tgl_in,
          CONVERT(varchar(19), b.tgl_buat, 120) AS tgl_out,
          c.bruto,
          c.rol,
          CONVERT(varchar(19), c.tgl_stop, 120)  AS tgl_mulai_mesin,
          CONVERT(varchar(19), c.tgl_mulai, 120) AS tgl_stop_mesin,
          c.ket_stopmesin
        FROM db_dying.tbl_schedule AS a
        INNER JOIN db_dying.tbl_montemp AS c
          ON a.id = c.id_schedule
        INNER JOIN db_dying.tbl_hasilcelup AS b
          ON c.id = b.id_montemp
        CROSS APPLY (
          SELECT
            -- total menit lama_proses (b.lama_proses)
            proc_min = CASE
              WHEN TRY_CONVERT(time(0), b.lama_proses) IS NOT NULL THEN
                DATEDIFF(
                  MINUTE,
                  CAST('00:00:00' AS time(0)),
                  TRY_CONVERT(time(0), b.lama_proses)
                )
              ELSE NULL
            END,
            -- total menit stop mesin (TIMEDIFF(c.tgl_mulai, c.tgl_stop))
            stop_min = CASE
              WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL THEN NULL
              ELSE DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai)
            END,
            -- HH:MM dasar dari lama_proses
            base_hhmm = CASE
              WHEN TRY_CONVERT(time(0), b.lama_proses) IS NOT NULL THEN
                LEFT(CONVERT(varchar(8), TRY_CONVERT(time(0), b.lama_proses), 108), 5)
              ELSE CAST(b.lama_proses AS varchar(10))
            END
        ) AS calc
        WHERE
          a.[status] = 'selesai'
          AND TRY_CONVERT(date, b.tgl_buat) IS NOT NULL
          AND TRY_CONVERT(date, b.tgl_buat) BETWEEN '$Awal' AND '$Akhir'
          $shft
        ORDER BY
          a.kapasitas DESC,
          a.no_mesin ASC"
    );

    if ($sql === false) {
      die(print_r(sqlsrv_errors(), true));
    }

    $no = 1;
    $totrol = 0;
    $totberat = 0;
	    $c = 0;
	
	    while ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
    ?>
      <tr valign="top">
        <td><?php echo $no; ?></td>
        <td><?php echo $rowd['g_shift']; ?></td>
        <td>'<?php echo $rowd['no_mesin']; ?></td>
        <td><?php echo $rowd['kapasitas']; ?></td>
        <td><?php echo $rowd['langganan']; ?></td>
        <td><?php echo $rowd['buyer']; ?></td>
        <td><?php echo $rowd['no_order']; ?></td>
        <td><?php echo $rowd['jenis_kain']; ?></td>
        <td><?php echo $rowd['warna']; ?></td>
        <td><?php echo $rowd['no_warna']; ?></td>
        <td><?php echo $rowd['kategori_warna']; ?></td>
        <td>'<?php echo $rowd['lot']; ?></td>
        <td align="right"><?php echo $rowd['bruto']; ?></td>
        <td align="center"><?php echo $rowd['proses']; ?></td>
        <td align="center"><?php echo $rowd['target']; ?></td>
        <td><?php echo $rowd['ket'] . "<br>" . $rowd['sts']; ?></td>
        <td><?php echo $rowd['k_resep']; ?></td>
        <td><?php echo $rowd['tgl_in']; ?></td>
        <td><?php echo $rowd['tgl_out']; ?></td>
        <td><?php echo $rowd['lama']; ?></td>
        <td><?= $rowd['tgl_mulai_mesin']; ?></td>
        <td><?= $rowd['tgl_stop_mesin']; ?></td>
        <td>
        <?php
          $waktuawal_stopmesin         = date_create($rowd['tgl_mulai_mesin']);
          $waktuakhir_stopmesin        = date_create($rowd['tgl_stop_mesin']);

          $diff_stopmesin              = date_diff($waktuawal_stopmesin, $waktuakhir_stopmesin);
          // echo sprintf("%02d", $diff_stopmesin->h) . ':'; echo sprintf("%02d", $diff_stopmesin->i);
          echo $diff_stopmesin->d . ' hari, '; echo $diff_stopmesin->h . ' jam, '; echo $diff_stopmesin->i . ' menit '; 
        ?>
        </td>
        <td><?= $rowd['ket_stopmesin']; ?></td>
        <td><?php echo $rowd['point']; ?></td>
      </tr>
    <?php
      $totrol += $rowd['rol'];
      $totberat += $rowd['bruto'];
      $no++;
    } ?>
    <tr>
      <td colspan="8" bgcolor="#99FF99">&nbsp;</td>
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
      <td bgcolor="#99FF99">&nbsp;</td>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th align="right" bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
  </table>
</body>
