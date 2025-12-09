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
$idkk = $_REQUEST['idkk'];
$act = $_GET['g'];
//-
$qTgl = mysqli_query($con, "SELECT DATE_FORMAT(now(),'%Y-%m-%d') as tgl_skrg, DATE_FORMAT(now(),'%Y-%m-%d')+ INTERVAL 1 DAY as tgl_besok");
$rTgl = mysqli_fetch_array($qTgl);
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
    if ($_GET['shft'] == "ALL") {
      $shft = " ";
    } else {
      $shft = " if(ISNULL(a.g_shift),b.g_shift,a.g_shift)='$_GET[shft]' AND ";
    }
    $sql = mysqli_query($con, "SELECT
                                a.no_mesin,
                                a.kapasitas,
                                b.g_shift,
                                b.operator_keluar as operator,
                                a.jenis_kain,
                                a.langganan,a.buyer,a.no_order,a.warna,a.no_warna,a.lot,
                                a.proses,
                                a.kategori_warna,	
                                if(
                                  ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,
                                  CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
                                b.point,
                                b.k_resep,
                                if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
                                a.target,
                                c.tgl_buat AS tgl_in,
                                b.tgl_buat AS tgl_out,
                                c.bruto,
                                c.rol,
                                c.tgl_stop AS tgl_mulai_mesin,
                                c.tgl_mulai AS tgl_stop_mesin,
                                c.ket_stopmesin 
                              FROM
                                tbl_schedule a
                                INNER JOIN tbl_montemp c ON a.id = c.id_schedule
                                INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
                              WHERE
                                a.`status` = 'selesai' 
                                AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir'
                                $shft
                              ORDER BY
                                a.kapasitas DESC, a.no_mesin ASC");

    $no = 1;
    $totrol = 0;
    $totberat = 0;
    $c = 0;

    while ($rowd = mysqli_fetch_array($sql)) {
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