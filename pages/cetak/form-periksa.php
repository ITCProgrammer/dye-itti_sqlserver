<?php
$con=mysql_connect("10.0.0.10", "dit", "4dm1n");
$db=mysql_select_db("dbknitt", $con)or die("Gagal Koneksi");
require_once('dompdf/dompdf_config.inc.php');
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
?>
<?php
$qry=mysql_query("SELECT *,now() as tgl FROM tbl_jadwal WHERE id='$_GET[id]'");
$r=mysql_fetch_array($qry);

?>
<?php if ($r[kategori]=="Over Houl") {
    $over="checked";
} else {
    $over="";
} ?>
<?php if ($r[kategori]=="Ringan") {
    $ringan="checked";
} else {
    $ringan="";
} ?>
<?php if ($r[sts]=="Berkala") {
    $berkala="checked";
} else {
    $berkala="";
} ?>
<?php if ($r[sts]=="Trouble") {
    $trouble="checked";
} else {
    $trouble="";
} ?>
<?php if ($r[sts]=="Ganti Konstruksi") {
    $ganti="checked";
} else {
    $ganti="";
}?>
<?php
$html='
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Formulir Pemeriksaan Mesin Knitting</title>
<style>
html{margin:0px;}
</style>
</head>

<body>
<table width="200" border="0" align="right">
         <tr>
            <td style="font-size: 9px;">No. Form</td>
            <td style="font-size: 9px;">:</td>
            <td style="font-size: 9px;">FW-14-KNT-26</td>
  </tr >
          <tr>
            <td style="font-size: 9px;">No. Revisi</td>
            <td style="font-size: 9px;">:</td>
            <td style="font-size: 9px;">01</td>
          </tr>
          <tr>
            <td style="font-size: 9px;">Tgl. Terbit</td>
            <td style="font-size: 9px;">:</td>
            <td style="font-size: 9px;"> 01 Oktober 2018</td>
          </tr>
</table>
<br>
<br>
<br>
<br>
<br>
<table width="100%" >
  <tbody>
    <tr>
      <td colspan="8" align="center"><h2><u>FORMULIR PEMERIKSAAN MESIN KNITTING</u></h2></td>
    </tr>
    <tr>
      <td width="17%">Tgl Cetak Form</td>
      <td width="19%">: '.$r[tgl].'</td>
      <td width="17%">Tgl Mulai Service</td>
      <td width="1%">:</td>
      <td colspan="2">&nbsp;</td>
      <td width="2%">Jam</td>
      <td width="15%">:</td>
    </tr>
    <tr>
      <td>No Mesin</td>
      <td>: '.$r[no_mesin].'</td>
      <td>Tgl Selesai Service</td>
      <td>:</td>
      <td colspan="2">&nbsp;</td>
      <td>Jam</td>
      <td>:</td>
    </tr>
    <tr>
      <td valign="top">Produksi (KG)</td>
      <td valign="top">: '.$r[kg_awal].'</td>
      <td valign="top">Kategori</td>
      <td valign="top">:</td>
      <td width="2%" valign="top"><input type="checkbox" '.$over.'/></td>
      <td width="27%" valign="top">Over Houl</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top"><input type="checkbox" '.$ringan.' /></td>
      <td valign="top">Ringan</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">Jenis Service</td>
      <td valign="top">:</td>
      <td valign="top"><input type="checkbox" '.$berkala.'/></td>
      <td valign="top">Berkala</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top"><input type="checkbox" '.$trouble.' /></td>
      <td valign="top">Trouble</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top"><input type="checkbox" '.$ganti.' /></td>
      <td valign="top">Ganti Konstruksi</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" border="1" class="table-list1" >
  <tbody>
    <tr align="center">
      <td width="3%" rowspan="2">No.</td>
      <td width="24%" rowspan="2">Bagian Mesin</td>
      <td width="7%" rowspan="2">Jumlah</td>
      <td colspan="2">Kondisi</td>
      <td colspan="2">Tindak Lanjut</td>
      <td width="33%" rowspan="2">Keterangan</td>
    </tr>
    <tr>
      <td width="8%" align="center">Baik</td>
      <td width="8%" align="center">Tidak</td>
      <td width="8%" align="center">Perbaikan</td>
      <td width="9%" align="center">Ganti</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td>Jarum</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">2.</td>
      <td>Sinker</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">3.</td>
      <td>Cylinder</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">4.</td>
      <td>Fan (Kipas)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">5.</td>
      <td>Yarn Guide (Ekor Babi)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">6.</td>
      <td>Positif Feeder (MPF)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">7.</td>
      <td>Pully</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">8.</td>
      <td>Tooth Belt</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">9.</td>
      <td>Tension Tape</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">10.</td>
      <td>Feeder</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">11.</td>
      <td>Baut Cam Box</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">12.</td>
      <td>Lengkok / CAM</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">13.</td>
      <td>Lampu</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">14.</td>
      <td>Take Down Units</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">15.</td>
      <td>Sensor Pintu</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">16.</td>
      <td>Sensor Jarum</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">17.</td>
      <td>Display Monitor</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">18.</td>
      <td>Lubrication Units</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">19.</td>
      <td>Creel / Rak Benang</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">20.</td>
      <td>Motor Dinamo</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">21.</td>
      <td>Vanbelt</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">22.</td>
      <td>Air Pressure</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">23.</td>
      <td>MER</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr style="height: 1.5in">
      <td colspan="8" valign="top">Catatan: '.$r[ket].' </td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" border="1" class="table-list1">
  <tbody>
    <tr valign="top">
      <td>Mekanik Service<br />
        1. '.$r[mekanik].'<br />
        2. '.$r[mekanik2].'<br />
        3. '.$r[mekanik3].'<br />
        4.</td>
      <td>Mekanik Stell Mesin</td>
      <td>Leader Produksi</td>
      <td>Kepala Bagian</td>
    </tr>
    <tr>
      <td>Tgl :</td>
      <td>Tgl :</td>
      <td>Tgl : </td>
      <td>Tgl :</td>
    </tr>
    <tr valign="top">
      <td>Tanda tangan :<br /><br /><br /><br /></td>
      <td>Tanda tangan :</td>
      <td>Tanda tangan :</td>
      <td>Tanda tangan :</td>
    </tr>
  </tbody>
</table>
</body>
</html>';


  $dompdf = new dompdf();
  $dompdf->load_html($html); //biar bisa terbaca htmlnya
  $dompdf->set_Paper('legal', 'portrait'); //portrait, landscape
  $dompdf->render();
  $dompdf->stream('FormPeriksa'.$r[no_mesin].'.pdf', array("Attachment"=>0)); //untuk pemberian nama
?>
