<?php

  require_once('dompdf/dompdf_config.inc.php');
  include '../../koneksi.php';
  $qrytgl=mysql_query("SELECT DATE_FORMAT(now(),'%d %M %Y %H:%i') as tgl"); $r2=mysql_fetch_array($qrytgl);
function fk($mc)
{
    $qry=mysql_query("SELECT @num:=@num+1 AS urut,kategori FROM
			tbl_jadwal, (SELECT @num := 0) T
		WHERE
			no_mesin = '$mc'
		ORDER BY
			id DESC
		LIMIT 3");
    $k=0;
    while ($dt=mysql_fetch_array($qry)) {
        $urut[$k]=$dt['urut']." ".$dt['kategori'];
        $k++;
    }
    $ringan="0";
    if ($urut[0]=="1 Ringan" and $urut[1]=="2 Ringan") {
        $ringan="2";
    } elseif ($urut[0]=="1 Ringan" and $urut[1]=="2 Over Houl") {
        $ringan="1";
    } elseif ($urut[0]=="1 Over Houl") {
        $ringan="0";
    }

    return $ringan;
}
$html ='
<html>
<head>
<title>:: Cetak Jadwal Preventif Mesin</title>
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<style>
html{margin:4px auto 4px;}
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
<table width="100%" border="0" class="table-list1">
  <thead>
<tr valign="top">
        <td colspan="12"><table width="100%" border="0" class="table-list1">
          <thead>
            <tr>
              <td width="6%" rowspan="4"><img src="../../dist/img/Indo.jpg" alt="" width="60" height="60"></td>
              <td width="75%" rowspan="4"><div align="center">
                <h2>JADWAL PREVENTIF MESIN</h2>
              </div></td>
              <td width="8%">No. Formulir</td>
              <td width="11%">: FW-14-KNT-25</td>
            </tr>
            <tr>
              <td>No. Revisi</td>
              <td>: 02</td>
            </tr>
            <tr>
              <td>Tgl. Terbit</td>
              <td>: 03 Desember 2018</td>
            </tr>
            <tr>
              <td>Halaman</td>
              <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /</td>
            </tr>
          <thead>
        </table></td>
    </tr>
<tr valign="top">
  <td colspan="12" style="border-left: 0px #000000 solid; border-right: 0px #000000 solid;">Tanggal :'.$r2[tgl].'</td>
  </tr>
    <tr>
      <td width="4%" rowspan="2" align="center">No.</td>
      <td width="8%" rowspan="2" align="center">No Mesin</td>
      <td width="5%" rowspan="2" align="center">Produksi (KG)</td>
      <td width="8%" rowspan="2" align="center">Status</td>
      <td width="8%" rowspan="2" align="center">Frekuensi Servis Ringan</td>
      <td colspan="3" align="center">Preventive *)</td>
      <td width="21%" rowspan="2" align="center">Keterangan</td>
      <td width="7%" rowspan="2" align="center">Tgl Selesai Service</td>
      <td width="13%" rowspan="2" align="center">Mekanik</td>
      <td width="7%" rowspan="2" align="center">Tanda Terima Form</td>
    </tr>
    <tr>
	  <td width="7%" align="center">Over Houl</td>
      <td width="6%" align="center">Ringan</td>
      <td width="6%" align="center">Hold</td>
    </tr>
  </thead>
    <tbody>';
  $sql=mysql_query(" SELECT
	a.no_mesin,a.batas_produksi,sum(b.berat_awal) as `KGS`
FROM
	tbl_mesin a
INNER JOIN tbl_inspeksi_detail b ON a.no_mesin=b.no_mc
GROUP BY
	a.no_mesin
ORDER BY
	a.no_mesin ASC ");
  while ($r=mysql_fetch_array($sql)) {
      $fks=fk($r['no_mesin']);

      $sql1=mysql_query(" SELECT sum(kg_awal) as kg_awal,sts FROM tbl_jadwal  WHERE no_mesin='$r[no_mesin]' ORDER BY id DESC LIMIT 1 ");
      $r1=mysql_fetch_array($sql1);
      $total=$r['KGS']-$r1['kg_awal'];
      if ($total > $r[batas_produksi] or $r1[sts]=="Hold") {
          $no++;
          if ($r1[sts]=="Hold") {
              $sts="Hold";
          } else {
              $sts="Berkala";
          }

          $html .='
      <tr valign="top">
        <td align="center">'.$no.'.</td>
        <td align="center">'.$r[no_mesin].'</td>
        <td align="right">'.$total.'</td>
        <td align="center">'.$sts.'</td>
        <td align="center">'.$fks.'</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      	<td>&nbsp;</td>
      	<td>&nbsp;</td>
      	<td>&nbsp;</td>
      	<td>&nbsp;</td>
      </tr>';
      }
  }
  $html .='<tr valign="top">
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="top">
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="top">
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="top">
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="top">
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

     </tbody>
</table>
<pre>Keterangan : *) Beri tanda tickmark (&#10004;) sesuai dengan aktual
                           Apabila preventive dihold, maka keterangan harus diisi</pre>
  <table width="100%" border="0" class="table-list1">
  <tr>
    <td width="15%">&nbsp;</td>
    <td width="31%"><div align="center">Dibuat Oleh</div></td>
    <td width="27%"><div align="center">Disetujui Oleh</div></td>
    <td width="27%"><div align="center">Diketahui Oleh</div></td>
    </tr>
  <tr>
    <td>Nama</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Jabatan</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Tanggal</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="60" valign="top">Tanda Tangan</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>

</body>
</html>';
  $dompdf = new dompdf();
  $dompdf->load_html($html); //biar bisa terbaca htmlnya
  $dompdf->set_Paper('legal', 'landscape');
  $dompdf->render();
  $dompdf->stream('Jadwal'.$r2[tgl].'.pdf', array("Attachment"=>0)); //untuk pemberian nama
