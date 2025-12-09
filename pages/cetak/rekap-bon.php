<?php
$con=mysqli_connect("10.0.0.10", "dit", "4dm1n");
$db=mysqli_select_db("dbknitt", $con)or die("Gagal Koneksi");
require_once('dompdf/dompdf_config.inc.php');
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
$qry1=mysqli_query("SELECT now() as tgl ");
$r1=mysqli_fetch_array($qry1);
?>
<?php

?>
<?php
  $html ='
<html>
<head>
<title>:: Rekap BON</title>
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
      <td colspan="9" align="center" style="font-size: 14px; padding: 0px 1px; border-right:0px #000000 solid; border-left:0px #000000 solid;border-top:0px #000000 solid;border-bottom:0px #000000 solid;"><strong>REKAP REALISASI BON PERMOHONAN BENANG</strong></td>
    </tr>
	<tr>
      <td colspan="9" align="center" style="font-size: 14px; padding: 0px 1px; border-right:0px #000000 solid; border-left:0px #000000 solid;border-top:0px #000000 solid;border-bottom:0px #000000 solid;"><strong>PER '.date('d F Y', strtotime($_GET[akhir])).'</strong></td>
    </tr>
	<tr>
      <td colspan="9" align="center" style="font-size: 14px; padding: 0px 1px; border-right:0px #000000 solid; border-left:0px #000000 solid;border-top:0px #000000 solid;">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%" rowspan="3" align="center" valign="middle">Tanggal</td>
      <td colspan="6" align="center" valign="middle">Realisasi</td>
      <td colspan="2" align="center" valign="middle">Jumlah Bon</td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">On Time</td>
      <td width="12%" align="center" valign="middle">Tercapai</td>
      <td colspan="2" align="center" valign="middle">Delay</td>
      <td width="14%" align="center" valign="middle">Tidak Tercapai</td>
      <td width="12%" rowspan="2" align="center" valign="middle">Bon</td>
      <td width="9%" rowspan="2" align="center" valign="middle">Qty</td>
    </tr>
    <tr>
      <td width="10%" align="center" valign="middle">Bon</td>
      <td width="10%" align="center" valign="middle">Qty</td>
      <td align="center" valign="middle">%</td>
      <td width="10%" align="center" valign="middle">Bon</td>
      <td width="9%" align="center" valign="middle">Qty</td>
      <td align="center" valign="middle">%</td>
    </tr>
  </thead>
	<tbody>';
$sql=mysqli_query(" SELECT
  DATE_FORMAT(tgl_terima_gdb,'%Y-%m-%d') as tgl,
	sum(if(b.tgl_kirim<=DATE_FORMAT(tgl_terima_gdb,'%Y-%m-%d'),b.kirim,0)) as qty_on,
	sum(if(b.tgl_kirim<=DATE_FORMAT(tgl_terima_gdb,'%Y-%m-%d'),1,0)) as bon_on,
	sum(if(b.tgl_kirim>DATE_FORMAT(tgl_terima_gdb,'%Y-%m-%d'),b.kirim,0)) as qty_dy,
	sum(if(b.tgl_kirim>DATE_FORMAT(tgl_terima_gdb,'%Y-%m-%d'),1,0)) as bon_dy,
	sum(b.kirim) as qty_tot,
	count(a.no_bon) as bon_tot

FROM
	tbl_bon a
LEFT JOIN
(SELECT tgl_kirim,sum(qty) as kirim,id_bon FROM tbl_realisasi GROUP BY id_bon) b ON a.id = b.id_bon
WHERE
	a.`status` = 'selesai'
AND DATE_FORMAT(a.tgl_terima_gdb,'%Y-%m-%d') BETWEEN '$_GET[awal]' AND '$_GET[akhir]'
GROUP BY DATE_FORMAT(tgl_terima_gdb,'%Y-%m-%d')
ORDER BY a.id ASC ");
  while ($r=mysqli_fetch_array($sql)) {
      $html .='<tr>
      <td align="Center">'.date('d M Y', strtotime($r[tgl])).'</td>
      <td align="Center">'.$r[bon_on].'</td>
      <td align="Center">'.$r[qty_on].'</td>
      <td align="Center">'.number_format(round(($r[qty_on]/$r[qty_tot])*100, 2), '2', '.', '').'</td>
      <td align="Center">'.$r[bon_dy].'</td>
      <td align="Center">'.$r[qty_dy].'</td>
      <td align="Center">'.number_format(round(($r[qty_dy]/$r[qty_tot])*100, 2), '2', '.', '').'</td>
      <td align="Center">'.$r[bon_tot].'</td>
      <td align="Center">'.$r[qty_tot].'</td>
    </tr>';
      $totBO=$totBO+$r[bon_on];
      $totQO=$totQO+$r[qty_on];
      $totBD=$totBD+$r[bon_dy];
      $totQD=$totQD+$r[qty_dy];
      $totBON=$totBON+$r[bon_tot];
      $totQTY=$totQTY+$r[qty_tot];
      $totC=number_format(round(($totQO/$totQTY)*100, 2), '2', '.', '');
      $totTC=number_format(round(($totQD/$totQTY)*100, 2), '2', '.', '');
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
    </tr>
    <tr>
      <td align="right"><strong>Total</strong></td>
      <td align="Center"><strong>'.$totBO.'</strong></td>
      <td align="Center"><strong>'.$totQO.'</strong></td>
      <td align="Center"><strong>'.$totC.'</strong></td>
      <td align="Center"><strong>'.$totBD.'</strong></td>
      <td align="Center"><strong>'.$totQD.'</strong></td>
      <td align="Center"><strong>'.$totTC.'</strong></td>
      <td align="Center"><strong>'.$totBON.'</strong></td>
      <td align="Center"><strong>'.$totQTY.'</strong></td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" border="0" class="table-list2">
    <tr>
      <td>&nbsp;</td>
      <td align="center">Dibuat Oleh: </td>
      <td align="center">Diperiksa Oleh: </td>
      <td align="center">Diketahui Oleh</td>
    </tr>
    <tr>
      <td>Nama</td>
      <td align="center">M. Kurniawan</td>
      <td align="center">Tajudin</td>
      <td align="center">Lia</td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td align="center">Clerk</td>
      <td align="center">Supervisor</td>
      <td align="center">Supervisor</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td align="center">'.date('d M Y', strtotime($r1[tgl])).'</td>
      <td align="center">'.date('d M Y', strtotime($r1[tgl])).'</td>
      <td align="center">'.date('d M Y', strtotime($r1[tgl])).'</td>
    </tr>
    <tr>
      <td style="height: 0.6in;">Tanda Tangan</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
</table>
</body>
</html>';


  $dompdf = new dompdf();
  $dompdf->load_html($html); //biar bisa terbaca htmlnya
  $dompdf->set_Paper('letter', 'portrait'); //portrait, landscape
  $dompdf->render();
  $dompdf->stream('RekapBON'.$_GET[awal].' s.d '.$_GET[akhir].'.pdf', array("Attachment"=>0)); //untuk pemberian nama
?>
