<?php
$con=mysql_connect("10.0.0.10", "dit", "4dm1n");
$db=mysql_select_db("dbknitt", $con)or die("Gagal Koneksi");
require_once('dompdf/dompdf_config.inc.php');
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
$qry1=mysql_query("SELECT now() as tgl ");
$r1=mysql_fetch_array($qry1);
?>
<?php

?>
<?php
  $html ='<html>
<head>
<title>:: Rekap Benang Warna Keluar</title>
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<style>
html{margin:2px auto 2px;}
input{
text-align:center;
border:hidden;
}
@media print {
  ::-webkit-input-placeholder { /* WebKit browsers */
      color: transparent;
  }
  :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
      color: transparent;
  }
  ::-moz-placeholder { /* Mozilla Firefox 19+ */
      color: transparent;
  }
  :-ms-input-placeholder { /* Internet Explorer 10+ */
      color: transparent;
  }
  .pagebreak { page-break-before:always; }
  .header {display:block}
  table thead
   {
    display: table-header-group;
   }
}
</style>
</head>
<body>
<br>
<table width="100%" border="0" class="table-list2">
  <thead>
	  <tr>
      <td colspan="12" align="center" style="font-size: 14px; padding: 0px 1px; border-right:0px #000000 solid; border-left:0px #000000 solid;border-top:0px #000000 solid;border-bottom:0px #000000 solid;"><strong>LAPORAN HARIAN KELUAR BENANG WARNA</strong></td>
    </tr>
	<tr>
      <td colspan="12" align="left" style="font-size: 10px; padding: 0px 1px; border-right:0px #000000 solid; border-left:0px #000000 solid;border-top:0px #000000 solid;">Tanggal: '.$_GET[awal].' s/d '.$_GET[akhir].'</td>
    </tr>
    <tr>
      <td width="5%" align="center" valign="middle" style="font-size: 9px;">No</td>
      <td width="11%" align="center" valign="middle" style="font-size: 9px;">Knitt</td>
      <td width="7%" align="center" valign="middle" style="font-size: 9px;">No.BON</td>
      <td width="7%" align="center" valign="middle" style="font-size: 9px;">PO</td>
      <td width="9%" align="center" valign="middle" style="font-size: 9px;">Supplier</td>
      <td width="10%" align="center" valign="middle" style="font-size: 9px;">Jenis Benang</td>
      <td width="10%" align="center" valign="middle" style="font-size: 9px;">Warna</td>
      <td width="9%" align="center" valign="middle" style="font-size: 9px;">No.Warna</td>
      <td width="7%" align="center" valign="middle" style="font-size: 9px;">Lot</td>
      <td width="8%" align="center" valign="middle" style="font-size: 9px;">D/K/P/C</td>
      <td width="6%" align="center" valign="middle" style="font-size: 9px;">Berat/Kg</td>
      <td width="11%" align="center" valign="middle" style="font-size: 9px;">Block</td>
    </tr>
  </thead>
	<tbody>';
$no=1;
$sql=mysql_query(" SELECT
	a.*, b.tgl_kirim,
	b.tujuan,
	sum(b.qty) AS qty_kirim,
	c.jns_benang,
	c.merek,
	d.no_po,
	b.lokasi,
	c.warna,
	c.nowarna,
	c.id as idwarna
FROM
	tbl_bon a
INNER JOIN tbl_realisasi b ON a.id = b.id_bon
LEFT JOIN tbl_permohonan_detail c ON a.id_mohon_detail=c.id
LEFT JOIN tbl_permohonan d ON c.id_mohon=d.id
WHERE
	a.`status` = 'selesai' AND c.`kd_benang` LIKE 'YND%'
AND DATE_FORMAT(a.tgl_terima_gdb,'%Y-%m-%d') BETWEEN '$_GET[awal]' AND '$_GET[akhir]'
GROUP BY no_bon
ORDER BY a.id ASC ");
 $dus=0;$cones=0;$palet=0;$karung=0;
 $tdus=0;$tcones=0;$tpalet=0;$tkarung=0;
  while ($r=mysql_fetch_array($sql)) {
      $html .='<tr>
      <td align="Center" style="font-size: 9px;">'.$no.'</td>
      <td align="Center" style="font-size: 9px;">'.$r[tujuan].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[no_bon].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[no_po].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[merek].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[jns_benang].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[warna].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[nowarna].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[lot].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[cns].$r[satuan].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[qty_kirim].'</td>
      <td align="Center" style="font-size: 9px;">'.$r[lokasi].'</td>
      </tr>
    ';
      if ($r[satuan]=="D") {
          $dus=$dus+$r[cns];
          $tdus=$tdus+$r[qty_kirim];
      } elseif ($r[satuan]=="C") {
          $cones=$cones+$r[cns];
          $tcones=$tcones+$r[qty_kirim];
      } elseif ($r[satuan]=="K") {
          $karung=$karung+$r[cns];
          $tkarung=$tkarung+$r[qty_kirim];
      } elseif ($r[satuan]=="P") {
          $palet=$palet+$r[cns];
          $tpalet=$tpalet+$r[qty_kirim];
      }
      $total=	$tdus+$tcones+$tkarung+$tpalet;
      $no++;
  }
 $html .='<tr>
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
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td style="font-size: 9px;">TOTAL</td>
   <td style="font-size: 9px;">DUS</td>
   <td style="font-size: 9px;" align="right">'.$dus.'</td>
   <td style="font-size: 9px;" align="right">'.$tdus.'</td>
   <td style="font-size: 9px;">&nbsp;</td>
 </tr>
 <tr>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td style="font-size: 9px;">TOTAL</td>
   <td style="font-size: 9px;">KARUNG</td>
   <td style="font-size: 9px;" align="right">'.$karung.'</td>
   <td style="font-size: 9px;" align="right">'.$tkarung.'</td>
   <td style="font-size: 9px;">&nbsp;</td>
 </tr>
 <tr>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td style="font-size: 9px;">TOTAL</td>
   <td style="font-size: 9px;">PALET</td>
   <td style="font-size: 9px;" align="right">'.$palet.'</td>
   <td style="font-size: 9px;" align="right">'.$tpalet.'</td>
   <td style="font-size: 9px;">&nbsp;</td>
 </tr>
 <tr>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td style="font-size: 9px;">TOTAL</td>
   <td style="font-size: 9px;">CONES</td>
   <td style="font-size: 9px;" align="right">'.$cones.'</td>
   <td style="font-size: 9px;" align="right">'.$tcones.'</td>
   <td style="font-size: 9px;">&nbsp;</td>
 </tr>
 <tr>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td style="font-size: 9px;"><strong>GRAND TOTAL</strong></td>
   <td style="font-size: 9px;">&nbsp;</td>
   <td style="font-size: 9px;">&nbsp;</td>
   <td style="font-size: 9px;" align="right"><strong>'.$total.'</strong></td>
   <td style="font-size: 9px;">&nbsp;</td>
 </tr>
  </tbody>
</table>
</body>
</html>
';


  $dompdf = new dompdf();
  $dompdf->load_html($html); //biar bisa terbaca htmlnya
  $dompdf->set_Paper('letter', 'portrait'); //portrait, landscape
  $dompdf->render();
  $dompdf->stream('BWarnaKeluar'.$_GET[awal].' s.d '.$_GET[akhir].'.pdf', array("Attachment"=>0)); //untuk pemberian nama
?>
