<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=report-produksi-" . substr($_GET['awal'], 0, 10) . ".xls"); //ganti nama sesuai keperluan
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
$idkk = $_REQUEST['idkk'];
$act = $_GET['g'];
//-
$qTgl = sqlsrv_query($con, "SELECT CONVERT(varchar(10), CAST(GETDATE() AS date), 23) AS tgl_skrg, CONVERT(varchar(10), DATEADD(day, 1, CAST(GETDATE() AS date)), 23) AS tgl_besok;");
$rTgl = sqlsrv_fetch_array($qTgl, SQLSRV_FETCH_ASSOC);
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
    <tr>
      <th rowspan="2" bgcolor="#99FF99">NO.</th>
      <th rowspan="2" bgcolor="#99FF99">SHIFT</th>
      <th rowspan="2" bgcolor="#99FF99">LANGGANAN</th>
      <th rowspan="2" bgcolor="#99FF99">BUYER</th>
      <th rowspan="2" bgcolor="#99FF99">NO ORDER</th>
      <th rowspan="2" bgcolor="#99FF99">KODE</th>
      <th rowspan="2" bgcolor="#99FF99">JENIS KAIN</th>
      <th rowspan="2" bgcolor="#99FF99">WARNA</th>
      <th rowspan="2" bgcolor="#99FF99">K.W</th>
      <th rowspan="2" bgcolor="#99FF99">LOT</th>
      <th rowspan="2" bgcolor="#99FF99">ROLL</th>
      <th rowspan="2" bgcolor="#99FF99">QTY</th>
      <th rowspan="2" bgcolor="#99FF99">PROSES</th>
      <th rowspan="2" bgcolor="#99FF99">SPEED</th>
      <th rowspan="2" bgcolor="#99FF99">Singeing 1 (Face)</th>
      <th rowspan="2" bgcolor="#99FF99">Singeing 2 (Back)</th>
      <th rowspan="2" bgcolor="#99FF99">Singeing Type</th>
      <th colspan="4" bgcolor="#99FF99">JAM PROSES</th>
      <th rowspan="2" bgcolor="#99FF99">LAMA PROSES</th>
      <th rowspan="2" bgcolor="#99FF99">OPERATOR</th>
      <th rowspan="2" bgcolor="#99FF99">Prod. Order</th>
      <th rowspan="2" bgcolor="#99FF99">Prod. Demand</th>
      <th rowspan="2" bgcolor="#99FF99">No Warna</th>
      <th rowspan="2" bgcolor="#99FF99">Lebar</th>
      <th rowspan="2" bgcolor="#99FF99">Gramasi</th>
      <th rowspan="2" bgcolor="#99FF99">ACUAN QUALITY</th>
      <th rowspan="2" bgcolor="#99FF99">ITEM</th>
      <th rowspan="2" bgcolor="#99FF99">NO PO</th>
      <th rowspan="2" bgcolor="#99FF99">TGL DELIVERY</th>
      <th rowspan="2" bgcolor="#99FF99">Keterangan</th>
    </tr>
    <tr>
      <th bgcolor="#99FF99">TGL</th>
      <th bgcolor="#99FF99">IN</th>
      <th bgcolor="#99FF99">TGL</th>
      <th bgcolor="#99FF99">OUT</th>
    </tr>
    <?php
      $Awal  = isset($_GET['awal']) ? $_GET['awal'] : '';
      $Akhir = isset($_GET['akhir']) ? $_GET['akhir'] : '';
      $Tgl   = substr($Awal, 0, 10);

      if ($Awal != $Akhir) {
        // Sama seperti MySQL: DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$Awal' AND '$Akhir'
        $Where = " AND CONVERT(char(16), c.tgl_update, 120) BETWEEN '$Awal' AND '$Akhir' ";
      } else {
        // Sama seperti MySQL: DATE_FORMAT(c.tgl_update, '%Y-%m-%d')='$Tgl'
        $Where = " AND CONVERT(date, c.tgl_update) = CONVERT(date, '$Tgl') ";
      }

      if (isset($_GET['shft']) && $_GET['shft'] != "ALL") {
        // Sama seperti MySQL: if(ISNULL(a.g_shift),c.g_shift,a.g_shift)='$_GET[shft]'
        $shft = " AND COALESCE(hc.g_shift, c.g_shift) = '" . $_GET['shft'] . "' ";
      } else {
        $shft = " ";
      }

      $sql = sqlsrv_query($con, "SELECT
            x.*,
            m.no_mesin AS mc
        FROM db_dying.tbl_mesin AS m
        LEFT JOIN
        (
            SELECT
                hc.ket,
                CASE
                    WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL THEN hc.lama_proses
                    ELSE
                        (
                            CASE
                                WHEN FLOOR(calc.menit_final / 60.0) BETWEEN 0 AND 9
                                    THEN '0' + CAST(CAST(FLOOR(calc.menit_final / 60.0) AS int) AS varchar(10))
                                ELSE CAST(CAST(FLOOR(calc.menit_final / 60.0) AS int) AS varchar(10))
                            END
                            + ':'
                            + CASE
                                WHEN (calc.menit_final % 60) BETWEEN 0 AND 9
                                    THEN '0' + CAST((calc.menit_final % 60) AS varchar(10))
                                ELSE CAST((calc.menit_final % 60) AS varchar(10))
                              END
                        )
                END AS lama_proses,
                CASE
                    WHEN calc.menit_final IS NULL THEN NULL
                    ELSE
                        CASE
                            WHEN FLOOR(calc.menit_final / 60.0) BETWEEN 0 AND 9
                                THEN '0' + CAST(CAST(FLOOR(calc.menit_final / 60.0) AS int) AS varchar(10))
                            ELSE CAST(CAST(FLOOR(calc.menit_final / 60.0) AS int) AS varchar(10))
                        END
                END AS jam,
                CASE
                    WHEN calc.menit_final IS NULL THEN NULL
                    ELSE
                        CASE
                            WHEN (calc.menit_final % 60) BETWEEN 0 AND 9
                                THEN '0' + CAST((calc.menit_final % 60) AS varchar(10))
                            ELSE CAST((calc.menit_final % 60) AS varchar(10))
                        END
                END AS menit,
                CASE
                    WHEN hc.proses IS NULL OR hc.proses = '' THEN b.proses
                    ELSE hc.proses
                END AS proses,
                b.buyer,
                b.langganan,
                b.no_order,
                b.jenis_kain,
                b.no_mesin,
                b.warna,
                b.lot,
                b.kapasitas,
                CASE
                    WHEN LEFT(b.kategori_warna, 1) = 'D' THEN 'Dark'
                    WHEN LEFT(b.kategori_warna, 1) = 'H' THEN 'Heater'
                    WHEN LEFT(b.kategori_warna, 1) = 'L' THEN 'Light'
                    WHEN LEFT(b.kategori_warna, 1) = 'M' THEN 'Medium'
                    WHEN LEFT(b.kategori_warna, 1) = 'S' THEN 'Dark'
                    WHEN LEFT(b.kategori_warna, 1) = 'W' THEN 'White'
                END AS kategori_warna,
                c.l_r,
                c.rol,
                c.bruto,
                CONVERT(char(10), c.tgl_buat, 23) AS tgl_in,
                CONVERT(char(10), hc.tgl_buat, 23) AS tgl_out,
                CONVERT(char(5), c.tgl_buat, 108) AS jam_in,
                CONVERT(char(5), hc.tgl_buat, 108) AS jam_out,
                d.g_shift AS shft,
                hc.status,
                hc.proses_point,
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
                hc.air_akhir,
                c.nokk_legacy,
                c.nodemand,
                c.leader,
                d.[operator],
                d.speed,
                d.singeing1,
                d.singeing2,
                d.singeing_type
            FROM db_dying.tbl_schedule AS b
            LEFT JOIN db_dying.tbl_montemp   AS c  ON c.id_schedule = b.id
            LEFT JOIN db_dying.tbl_hasilcelup AS hc ON hc.id_montemp = c.id
            INNER JOIN db_dying.tbl_bakbul   AS d  ON b.nokk = d.no_kk
            OUTER APPLY
            (
                SELECT
                    TRY_CONVERT(int, LEFT(LTRIM(RTRIM(hc.lama_proses)),
                                          CHARINDEX(':', LTRIM(RTRIM(hc.lama_proses))) - 1)) AS lama_h,
                    TRY_CONVERT(int, SUBSTRING(LTRIM(RTRIM(hc.lama_proses)),
                                              CHARINDEX(':', LTRIM(RTRIM(hc.lama_proses))) + 1, 2)) AS lama_m
            ) AS lp
            OUTER APPLY
            (
                SELECT
                    CASE
                        WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL THEN NULL
                        ELSE CAST(FLOOR( DATEDIFF_BIG(MILLISECOND, c.tgl_stop, c.tgl_mulai) / 60000.0 ) AS int)
                    END AS diff_menit
            ) AS td
            OUTER APPLY
            (
                SELECT
                    CASE
                        WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL
                            THEN (lp.lama_h * 60 + lp.lama_m)
                        ELSE (lp.lama_h * 60 + lp.lama_m) - td.diff_menit
                    END AS menit_final
            ) AS calc
            WHERE
                1 = 1
        $shft
        $Where
        ) AS x
            ON (m.no_mesin = x.no_mesin OR m.no_mc_lama = x.no_mesin)
        WHERE
            x.speed <> 0
        ORDER BY
            m.no_mesin;
        ");

      $no = 1;
      $c = 0;
      $totrol = 0;
      $totberat = 0;

      if ($sql === false) {
        echo '<tr><td colspan=\"31\">Query error: ' . htmlspecialchars(print_r(sqlsrv_errors(), true)) . '</td></tr>';
      } else {
        while ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $q_itxviewkk    = db2_exec($conn2, "SELECT 
                                          LISTAGG(DISTINCT TRIM(LOT), ', ') AS LOT,
                                          LISTAGG(DISTINCT TRIM(SUBCODE01), ', ') AS SUBCODE01 
                                        FROM 
                                          ITXVIEWKK 
                                        WHERE 
                                          PRODUCTIONORDERCODE = '$rowd[nokk]'");
        $d_itxviewkk    = db2_fetch_assoc($q_itxviewkk);
    ?>
      <tr valign="top">
        <td><?php echo $no; ?></td>
        <td><?php echo $rowd['shft']; ?></td>
        <td><?php echo $rowd['langganan']; ?></td>
        <td><?php echo $rowd['buyer']; ?></td>
        <td><?php echo $rowd['no_order']; ?></td>
        <td><?= $d_itxviewkk['SUBCODE01'];  ?></td>
        <td><?php echo $rowd['jenis_kain']; ?></td>
        <td><?php echo $rowd['warna']; ?></td>
        <td><?php echo $rowd['kategori_warna']; ?></td>
        <td>'<?php echo $rowd['lot']; ?></td>
        <td><?php if ($rowd['tgl_out'] != "") {
              $rol = $rowd['rol'];
            } else {
              $rol = 0;
            }
            echo $rol; ?></td>
        <td><?php if ($rowd['tgl_out'] != "") {
              $brt = $rowd['bruto'];
            } else {
              $brt = 0;
            }
            echo $brt; ?></td>
        <td><?php echo $rowd['speed']; ?></td>
        <td><?php echo $rowd['speed']; ?></td>
        <td>'<?php echo $rowd['singeing1']; ?></td>
        <td>'<?php echo $rowd['singeing2']; ?></td>
        <td><?php echo $rowd['singeing_type']; ?></td>
        <td><?php echo $rowd['tgl_in']; ?></td>
        <td><?php echo $rowd['jam_in']; ?></td>
        <td><?php echo $rowd['tgl_out']; ?></td>
        <td><?php echo $rowd['jam_out']; ?></td>
        <td><?php if ($rowd['lama_proses'] != "") { echo $rowd['jam'] . ":" . $rowd['menit']; } ?></td>
        <td><?php echo $rowd['operator']; ?></td>
        <td>'<?php echo $rowd['nokk_legacy']; ?></td>
        <td>'<?php echo $rowd['nodemand']; ?></td>
        <td>'<?php echo $rowd['color_code']; ?></td>
        <td><?php echo $rowd['lebar']; ?></td>
        <td><?php echo $rowd['gramasi']; ?></td>
        <td><?php echo $rowd['no_hanger']; ?></td>
        <td><?php echo $rowd['no_item']; ?></td>
        <td><?php echo $rowd['po']; ?></td>
        <td><?php echo $rowd['tgl_delivery']->format('Y-m-d'); ?></td>
        <td><?php echo $rowd['proses_point']; ?></td>
      </tr>
    <?php
      $totrol += $rol;
      $totberat += $brt;
      $no++;
    }
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
      <th bgcolor="#99FF99">&nbsp;</th>
      <td bgcolor="#99FF99">&nbsp;</td>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th colspan="3">&nbsp;</th>
      <th colspan="9">DIBUAT OLEH:</th>
      <th colspan="11">DIPERIKSA OLEH:</th>
      <th colspan="10">DIKETAHUI OLEH:</th>
    </tr>
    <tr>
      <td colspan="3">NAMA</td>
      <td colspan="9">&nbsp;</td>
      <td colspan="11">&nbsp;</td>
      <td colspan="10">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">JABATAN</td>
      <td colspan="9">&nbsp;</td>
      <td colspan="11">&nbsp;</td>
      <td colspan="10">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">TANGGAL</td>
      <td colspan="9">&nbsp;</td>
      <td colspan="11">&nbsp;</td>
      <td colspan="10">&nbsp;</td>
    </tr>
    <tr>
      <td height="60" colspan="3" valign="top">TANDA TANGAN</td>
      <td colspan="9">&nbsp;</td>
      <td colspan="11">&nbsp;</td>
      <td colspan="10">&nbsp;</td>
    </tr>
  </table>
</body>