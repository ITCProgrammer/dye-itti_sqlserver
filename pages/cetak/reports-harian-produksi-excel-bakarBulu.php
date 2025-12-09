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
      $Awal = $_GET['awal'];
      $Akhir = $_GET['akhir'];
      $Tgl = substr($Awal, 0, 10);
      if ($Awal != $Akhir) {
        $Where = " DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$Awal' AND '$Akhir' ";
      } else {
        $Where = " DATE_FORMAT(c.tgl_update, '%Y-%m-%d')='$Tgl' ";
      }
      if ($_GET['shft'] == "ALL") {
        $shft = " ";
      } else {
        $shft = " if(ISNULL(a.g_shift),c.g_shift,a.g_shift)='$_GET[shft]' AND ";
      }
      $sql = mysqli_query($con, "SELECT x.*, a.no_mesin as mc 
                                  FROM tbl_mesin a
                                    LEFT JOIN
                                      (SELECT
                                        a.ket,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama_proses,
                                        TIME_FORMAT(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))),'%H') as jam,
                                        TIME_FORMAT(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))),'%i') as menit,
                                        if(a.proses='' or ISNULL(a.proses),b.proses,a.proses) as proses,
                                        b.buyer,
                                        b.langganan,
                                        b.no_order,
                                        b.jenis_kain,
                                        b.no_mesin,
                                        b.warna,
                                        b.lot,
                                        b.kapasitas,
                                        CASE
                                          WHEN SUBSTR(b.kategori_warna, 1,1) = 'D' THEN 'Dark'
                                          WHEN SUBSTR(b.kategori_warna, 1,1) = 'H' THEN 'Heater'
                                          WHEN SUBSTR(b.kategori_warna, 1,1) = 'L' THEN 'Light'
                                          WHEN SUBSTR(b.kategori_warna, 1,1) = 'M' THEN 'Medium'
                                          WHEN SUBSTR(b.kategori_warna, 1,1) = 'S' THEN 'Dark'
                                          WHEN SUBSTR(b.kategori_warna, 1,1) = 'W' THEN 'White'
                                        END AS kategori_warna,
                                        c.l_r,
                                        c.rol,
                                        c.bruto,
                                        DATE_FORMAT(c.tgl_buat,'%Y-%m-%d') as tgl_in,
                                        DATE_FORMAT(a.tgl_buat,'%Y-%m-%d') as tgl_out,
                                        DATE_FORMAT(c.tgl_buat,'%H:%i') as jam_in,
                                        DATE_FORMAT(a.tgl_buat,'%H:%i') as jam_out,
                                        d.g_shift as shft,
                                        a.status,
                                        a.proses_point,
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
                                        c.nodemand,
                                        c.leader,
                                        d.operator,
                                        d.speed,
                                        d.singeing1,
                                        d.singeing2,
                                        d.singeing_type
                                      FROM
                                        tbl_schedule b
                                          LEFT JOIN  tbl_montemp c ON c.id_schedule = b.id
                                          LEFT JOIN tbl_hasilcelup a ON a.id_montemp=c.id
                                          INNER JOIN tbl_bakbul d ON b.nokk = d.no_kk
                                      WHERE
                                        $shft 
                                        $Where
                                      )x
                                    ON (a.no_mesin=x.no_mesin or a.no_mc_lama=x.no_mesin)
                                  WHERE x.speed != 0
                                  ORDER BY a.no_mesin");

      $no = 1;
      $c = 0;
      $totrol = 0;
      $totberat = 0;

      while ($rowd = mysqli_fetch_array($sql)) {
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
        <td><?php echo $rowd['tgl_delivery']; ?></td>
        <td><?php echo $rowd['proses_point']; ?></td>
      </tr>
    <?php
      $totrol += $rol;
      $totberat += $brt;
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