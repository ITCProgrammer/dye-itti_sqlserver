<?php
$con=mysql_connect("10.0.0.10", "dit", "4dm1n");
$db=mysql_select_db("dbknitt", $con)or die("Gagal Koneksi");
require_once('dompdf/dompdf_config.inc.php');
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
$sql=mysql_query("SELECT DATE_FORMAT(now(),'%d %M %Y %H:%i') as tgl");
$data=mysql_fetch_array($sql);
?>
<?php

?>
<?php
  $html ='
<head>
<title>:: Form List Permintaan</title>
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
<h2>List Permohonan Benang</h2>
Tanggal: '.$data[tgl].$_POST[cek][$no].'
<table width="100%" border="0" class="table-list2">
<thead>
	<tr>
      <td width="2%" align="center" style="font-size: 9px;"><strong>No</strong></td>
      <td width="3%" align="center" style="font-size: 9px;"><strong>Bon</strong></td>
      <td width="5%" align="center" style="font-size: 9px;"><strong>Kode</strong></td>
      <td width="7%" align="center" style="font-size: 9px;"><strong>PO</strong></td>
      <td width="9%" align="center" style="font-size: 9px;"><strong>Jenis Benang</strong></td>
      <td width="6%" align="center" style="font-size: 9px;"><strong>Lot</strong></td>
      <td width="4%" align="center" style="font-size: 9px;"><strong>KG</strong></td>
      <td width="3%" align="center" style="font-size: 9px;"><strong>D/K/P/C</strong></td>
      <td width="7%" align="center" style="font-size: 9px;"><strong>Note</strong></td>
      <td width="5%" align="center" style="font-size: 9px;"><strong>Lokasi</strong></td>
      <td width="3%" align="center" style="font-size: 9px;"><strong>D/K/P/C</strong></td>
      <td width="4%" align="center" style="font-size: 9px;"><strong>KG</strong></td>
      <td width="7%" align="center" style="font-size: 9px;"><strong>Tgl. Produksi</strong></td>
      <td width="6%" align="center" style="font-size: 9px;"><strong>Tgl. Masuk</strong></td>
    </tr>
</thead>
		  <tbody>';
$qry=mysql_query("SELECT a.*,b.kd_benang,b.jns_benang,c.no_po FROM tbl_bon a
INNER JOIN tbl_permohonan_detail b ON a.id_mohon_detail=b.id
INNER JOIN tbl_permohonan c ON b.id_mohon=c.id
WHERE a.`status`='in progress' AND st_rmp='sudah terima'");
$no=1;
while ($r=mysql_fetch_array($qry)) {
    if ($_POST[cek][$no]==$r['id']) {
        $qry2=mysql_query("SELECT a.* from tbl_realisasi_benang a
INNER JOIN
(SELECT @num:=@num+1 as nomor,id FROM tbl_realisasi_benang
, (SELECT @num := 0) T
WHERE id_bon='$r[id]') b  ON a.id=b.id
WHERE b.nomor=1");
        $r2=mysql_fetch_array($qry2);
        $html .='<tr>
      <td align="center" style="font-size: 9px;">'.$no.'</td>
      <td align="center" style="font-size: 9px;">'.$r[no_bon].'</td>
      <td align="center" style="font-size: 9px;">'.$r[kd_benang].'</td>
      <td align="center" style="font-size: 9px;">'.$r[no_po].'</td>
      <td style="font-size: 9px;">'.$r[jns_benang].'</td>
      <td align="center" style="font-size: 9px;">'.$r[lot].'</td>
      <td align="right" style="font-size: 9px;">'.$r[qty].'</td>
	  <td align="center" style="font-size: 9px;">'.$r['cns']." ".$r[satuan].'</td>
	  <td style="font-size: 9px;">'.$r[ket].'<br>
	    '.$r[note_rmp].'</td>
      <td align="center" style="font-size: 9px;">'.$r2[lokasi].'</td>
      <td align="center" style="font-size: 9px;">'.$r2[qty]." ".$r2[satuan].'</td>
      <td align="right" style="font-size: 9px;">'.$r2[kg].'</td>
      <td align="center" style="font-size: 9px;">'.$r2[tgl_produksi].'</td>
      <td align="center" style="font-size: 9px;">'.$r2[tgl_masuk].'</td>
      </tr>
    ';
        $qry1=mysql_query("SELECT a.* from tbl_realisasi_benang a
INNER JOIN
(SELECT @num:=@num+1 as nomor,id FROM tbl_realisasi_benang
, (SELECT @num := 0) T
WHERE id_bon='$r[id]') b  ON a.id=b.id
WHERE b.nomor > 1");
        while ($r1=mysql_fetch_array($qry1)) {
            $html .='<tr>
      <td align="center" style="font-size: 9px;">&nbsp;</td>
      <td align="center" style="font-size: 9px;">&nbsp;</td>
      <td align="center" style="font-size: 9px;">&nbsp;</td>
      <td style="font-size: 9px;">&nbsp;</td>
      <td style="font-size: 9px;">&nbsp;</td>
      <td align="center" style="font-size: 9px;">&nbsp;</td>
      <td align="right" style="font-size: 9px;">&nbsp;</td>
      <td align="center" style="font-size: 9px;">&nbsp;</td>
      <td align="center" style="font-size: 9px;">&nbsp;</td>
      <td align="center" style="font-size: 9px;">'.$r1[lokasi].'</td>
      <td align="center" style="font-size: 9px;">'.$r1[qty]." ".$r1[satuan].'</td>
      <td align="right" style="font-size: 9px;">'.$r1[kg].'</td>
      <td align="center" style="font-size: 9px;">'.$r1[tgl_produksi].'</td>
      <td align="center" style="font-size: 9px;">'.$r1[tgl_masuk].'</td>
      </tr>
    ';
        }
    }
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
</table>
  </tbody>
Keterangan :
<br>
*) D/K/P/C = Dus/Karung/Palet/Cones<br>

</body>
</html>';


  $dompdf = new dompdf();
  $dompdf->load_html($html); //biar bisa terbaca htmlnya
  $dompdf->set_Paper('letter', 'portrait'); //portrait, landscape
  $dompdf->render();
  $dompdf->stream('ListPermohonanBenang.pdf', array("Attachment"=>0)); //untuk pemberian nama
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
