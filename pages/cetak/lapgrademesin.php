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
$html ='
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="logo.png">
<title>Laporan Harian Inspeksi</title>
<style>
html{margin:0px;}
</style>
</head>

<body>
<h2><u>LAPORAN GRADE HASIL PRODUKSI RAJUT PER HARI</u></h2>
<h3>Tanggal: '.$_GET[tgl_tutup].'<h3>
<table width="100%" border="0" class="table-list" >
  <thead>
    <tr>
      <td colspan="3" align="center">PRODUKSI</td>
      <td colspan="8" align="center">GRADE</td>
    </tr>
    <tr>
      <td align="center">NO MC</td>
      <td align="center">ROLL</td>
      <td align="center">KG</td>
      <td align="center">A</td>
      <td align="center">%</td>
      <td align="center">B</td>
      <td align="center">%</td>
      <td align="center">C</td>
      <td align="center">%</td>
      <td align="center">BS</td>
      <td align="center">%</td>
    </tr>
	</thead>';
    $sql=mysql_query(" SELECT * FROM tbl_lap_ins WHERE tgl_tutup='$_GET[tgl_tutup]' GROUP BY no_mc ");
  while ($r=mysql_fetch_array($sql)) {
      $html .='
	<tbody>
	<tr>
      <td align="center">'.$r[no_mc].'</td>
      <td align="center">'.$r[roll].'</td>
      <td align="right">'.number_format($r[kg], 3).'</td>
      <td align="right">'.number_format($r[a], 3).'</td>
      <td align="right">'.number_format(round(($r[a]/$r[kg])*100, 3), 3).'</td>
      <td align="right">'.number_format($r[b], 3).'</td>
      <td align="right">'.number_format(round(($r[b]/$r[kg])*100, 3), 3).'</td>
      <td align="right">'.number_format($r[c], 3).'</td>
      <td align="right">'.number_format(round(($r[c]/$r[kg])*100, 3), 3).'</td>
      <td align="right">'.number_format($r[bs], 3).'</td>
      <td align="right">'.number_format(round(($r[bs]/$r[kg])*100, 3), 3).'</td>
    </tr>
	</tbody>';
      $troll=$troll+$r[roll];
      $tkg=$tkg+$r[kg];
      $ta=$ta+$r[a];
      $tb=$tb+$r[b];
      $tc=$tc+$r[c];
      $tbs=$tbs+$r[bs];
  }
    $html .='
	<tfoot>
	<tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
	<tr>
      <td align="center">TOTAL</td>
      <td align="center">'.$troll.'</td>
      <td align="right">'.number_format($tkg, 3).'</td>
      <td align="right">'.number_format($ta, 3).'</td>
      <td align="right">&nbsp;</td>
      <td align="right">'.number_format($tb, 3).'</td>
      <td align="right">&nbsp;</td>
      <td align="right">'.number_format($tc, 3).'</td>
      <td align="right">&nbsp;</td>
      <td align="right">'.number_format($tbs, 3).'</td>
      <td align="right">&nbsp;</td>
    </tr>
	<tr>
	    <td colspan="11" align="center" style="border-top:1px #000000 solid;
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">
	';
$html .= '<table width="100%" border="0" class="table-list">
    <tr>
      <td rowspan="2" align="center">SHIFT</td>
      <td colspan="2" align="center">PRODUKSI</td>
      <td colspan="8" align="center">GRADE</td>
    </tr>
    <tr>
      <td align="center">ROLL</td>
      <td align="center">KG</td>
      <td align="center">A</td>
      <td align="center">%</td>
      <td align="center">B</td>
      <td align="center">%</td>
      <td align="center">C</td>
      <td align="center">%</td>
      <td align="center">BS</td>
      <td align="center">%</td>
    </tr>';
$sql1=mysql_query("SELECT
	shift,
	sum(roll) AS roll,
	sum(kg) AS kg,
	sum(a) AS a,
	sum(b) AS b,
	sum(c) AS c,
	sum(bs) AS bs
FROM
	tbl_lap_ins
WHERE
	tgl_tutup ='$_GET[tgl_tutup]'
GROUP BY shift ");
  while ($r1=mysql_fetch_array($sql1)) {
      $html .='<tr>
      <td align="center">'.$r1[shift].'</td>
      <td align="center">'.$r1[roll].'</td>
      <td align="right">'.number_format($r1[kg], 3).'</td>
      <td align="right">'.number_format($r1[a], 3).'</td>
      <td align="right">'.number_format(round(($r1[a]/$r1[kg])*100, 3), 3).'</td>
      <td align="right">'.number_format($r1[b], 3).'</td>
      <td align="right">'.number_format(round(($r1[b]/$r1[kg])*100, 3), 3).'</td>
      <td align="right">'.number_format($r1[c], 3).'</td>
      <td align="right">'.number_format(round(($r1[c]/$r1[kg])*100, 3), 3).'</td>
      <td align="right">'.number_format($r1[bs], 3).'</td>
      <td align="right">'.number_format(round(($r1[bs]/$r1[kg])*100, 3), 3).'</td>
    </tr>';
      $tRoll=$tRoll+$r1[roll];
      $tKg=$tKg+$r1[kg];
      $tA=$tA+$r1[a];
      $tB=$tB+$r1[b];
      $tC=$tC+$r1[c];
      $tBs=$tBs+$r1[bs];
  }
    $html .= '
    <tr>
      <td align="center">TOTAL</td>
      <td align="center">'.$tRoll.'</td>
      <td align="right">'.number_format($tKg, 3).'</td>
      <td align="right">'.number_format($tA, 3).'</td>
      <td align="right">&nbsp;</td>
      <td align="right">'.number_format($tB, 3).'</td>
      <td align="right">&nbsp;</td>
      <td align="right">'.number_format($tC, 3).'</td>
      <td align="right">&nbsp;</td>
      <td align="right">'.number_format($tBs, 3).'</td>
      <td align="right">&nbsp;</td>
    </tr>
</table>
		</td>
      </tr>
  <tfoot>
</table>
</body>
</html>';

  $dompdf = new dompdf();
  $dompdf->load_html($html); //biar bisa terbaca htmlnya
  $dompdf->set_Paper('legal', 'portrait'); //portrait, landscape
  $dompdf->render();
  $dompdf->stream('LapHarianInspeksi'.$r[no_mesin].'.pdf', array("Attachment"=>0)); //untuk pemberian nama
?>
