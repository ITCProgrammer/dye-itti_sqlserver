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
$qry=mysql_query("SELECT a.*,b.kd_benang,b.jns_benang,c.no_po,now() as tgl FROM tbl_bon a
INNER JOIN tbl_permohonan_detail b ON a.id_mohon_detail=b.id
INNER JOIN tbl_permohonan c ON b.id_mohon=c.id
WHERE a.id='$_GET[id]'");
$r=mysql_fetch_array($qry);

?>
<?php
$html ='
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Form BPB</title>
<style>
html{margin:0px;}
</style>
</head>

<body>

<table width="100%" >
  <tbody>
    <tr>
      <td colspan="8" align="center"><h2><u>BON PERMOHONAN BENANG</u></h2></td>
    </tr>
    <tr>
      <td width="17%">No BON</td>
      <td width="19%">: '.$r[no_bon].'</td>
      <td width="17%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td width="8%">Status Bon</td>
      <td width="15%">: '.$r[status].'</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>: '.date('d M Y', strtotime($r[tgl_bon])).'</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">Knitting Order</td>
      <td valign="top">: '.$r[no_po].'</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td width="2%" valign="top">&nbsp;</td>
      <td width="21%" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">Keterangan</td>
      <td rowspan="2" valign="top">: '.$r[ket].'</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" border="1" class="table-list1" >
  <tbody>
    <tr>
      <td width="11%" align="center">Kode Benang</td>
      <td width="37%" align="center">Jenis Benang</td>
      <td width="18%" align="center">No. Lot</td>
      <td width="5%" align="center">cones</td>
      <td width="4%" align="center">Box</td>
      <td width="12%" align="center">KG</td>
      <td width="13%" align="center">Permintaan Delivery</td>
    </tr>';
$qry1=mysql_query("SELECT a.*,b.kd_benang,b.jns_benang,c.no_po,now() as tgl FROM tbl_bon a
INNER JOIN tbl_permohonan_detail b ON a.id_mohon_detail=b.id
INNER JOIN tbl_permohonan c ON b.id_mohon=c.id
WHERE a.id='$_GET[id]'");
$r1=mysql_fetch_array($qry1);
    $html .='<tr>
      <td align="center">'.$r1[kd_benang].'</td>
      <td>'.$r1[jns_benang].'</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">'.date('d-M-Y', strtotime($r1[tgl_delivery_awal])).' s/d '.date('d-M-Y', strtotime($r1[tgl_delivery_akhir])).'</td>
    </tr>';

$html .='</tbody>
</table>
	<font style="font-size: 14px;">Realisasi:</font><br>
<table width="100%" border="1" class="table-list1" >
  <tbody>
    <tr>
      <td width="11%" align="center">Tanggal</td>
      <td width="37%" align="center">No Transfer Out</td>
      <td width="18%" align="center">No. Lot</td>
      <td width="5%" align="center">cones</td>
      <td width="4%" align="center">Box</td>
      <td width="12%" align="center">KG</td>
      <td width="13%" align="center">Keterangan</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" border="1" class="table-list1">
  <tbody>
    <tr>
      <td align="center">Dibuat Oleh: </td>
      <td align="center">Diketahui Oleh: </td>
      <td align="center">Diterima Oleh:</td>
    </tr>
    <tr valign="top" align="center">
      <td><br /><br /><br /><br />'.strtoupper($r[userid]).'</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</body>
</html>';


  $dompdf = new dompdf();
  $dompdf->load_html($html); //biar bisa terbaca htmlnya
  $dompdf->set_Paper('legal', 'portrait'); //portrait, landscape
  $dompdf->render();
  $dompdf->stream('FormBPB'.$r[no_bon].'.pdf', array("Attachment"=>0)); //untuk pemberian nama
?>
<!--<table width="200" border="0" align="right">
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
            <td style="font-size: 9px;">&nbsp;</td>
          </tr>
</table>
<br>
<br>
<br>
<br>
<br>-->
