<?php
//$lReg_username=$_SESSION['labReg_username'];
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../koneksiLAB.php";
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
$sqlbg=mysqli_query($con,"SELECT * FROM tbl_setting_mesin where id='$_GET[idstm]'");
$rowbg=mysqli_fetch_array($sqlbg);
//-
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<link href="styles_monitor.css" rel="stylesheet" type="text/css">-->
<title>Cetak Setting Produk Dyeing</title>
<script>

// set portrait orientation

jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);

// set top margins in millimeters
jsPrintSetup.setOption('marginTop', 0);
jsPrintSetup.setOption('marginBottom', 0);
jsPrintSetup.setOption('marginLeft', 0);
jsPrintSetup.setOption('marginRight', 0);

// set page header
jsPrintSetup.setOption('headerStrLeft', '');
jsPrintSetup.setOption('headerStrCenter', '');
jsPrintSetup.setOption('headerStrRight', '');

// set empty page footer
jsPrintSetup.setOption('footerStrLeft', '');
jsPrintSetup.setOption('footerStrCenter', '');
jsPrintSetup.setOption('footerStrRight', '');

// clears user preferences always silent print value
// to enable using 'printSilent' option
jsPrintSetup.clearSilentPrint();

// Suppress print dialog (for this context only)
jsPrintSetup.setOption('printSilent', 1);

// Do Print 
// When print is submitted it is executed asynchronous and
// script flow continues after print independently of completetion of print process! 
jsPrintSetup.print();

window.addEventListener('load', function () {
    var rotates = document.getElementsByClassName('rotate');
    for (var i = 0; i < rotates.length; i++) {
        rotates[i].style.height = rotates[i].offsetWidth + 'px';
    }
});
// next commands

	
</script>
	<style>
		
body,td,th {
  /*font-family: Courier New, Courier, monospace; */
	font-family:sans-serif, Roman, serif;
}
body{
	margin: 0px auto 0px;
	padding: 0.5px;
	font-size: 8px;
	color: #000;
	width: 98%;
	background-position: top;
	background-color: #fff;
}
.table-list {
	clear: both;
	text-align: left;
	border-collapse: collapse;
	margin: 0px 0px 5px 0px;
	background:#fff;	
}
.table-list td {
	color: #333;
	font-size:12px;
	border-color: #fff;
	border-collapse: collapse;
	vertical-align: center;
	padding: 0px 1px;
	border-bottom:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;

	
}
pre {
	font-family:sans-serif, Roman, serif;
	clear:both;
	margin: 0px auto 0px;
	padding: 0px;
	white-space: pre-wrap;       /* Since CSS 2.1 */
    white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
    white-space: -pre-wrap;      /* Opera 4-6 */
    white-space: -o-pre-wrap;    /* Opera 7 */
    word-wrap: break-word; 
}
.table-list1 {
	clear: both;
	text-align: left;
	border-collapse: collapse;
	margin: 0px 0px 3px 0px;
		
}
.table-list1 td {
	color: #333;
	font-size:11px;
	border-color: #fff;
	border-collapse: collapse;
	vertical-align: center;
	padding: 0px 1px;
	border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;
	
	
}	
body:before{
<?php 
if($rowbg['kk_kestabilan']=='1'){
?>
  content: 'KK KESTABILAN';
<?php }else{ ?>
  content: '';
<?php } ?>
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: -1;
  
  color: #d0d0d0;
  font-size: 100px;
  font-weight: 500px;
  display: grid;
  justify-content: center;
  align-content: center;
  opacity: 0.3;
  transform: rotate(-45deg);
}		
body {
        -webkit-print-color-adjust: exact !important; /* Chrome, Safari */
        color-adjust: exact !important; /*Firefox*/
   }
		
	</style>
</head>

<body>
<?php
// $sqlc="select convert(char(10),CreateTime,103) as TglBonResep,convert(char(10),CreateTime,108) as JamBonResep,ID_NO,COLOR_NAME,PROGRAM_NAME,PRODUCT_LOT,VOLUME,PROGRAM_CODE,YARN as NoKK,TOTAL_WT,USER25 from ticket_title where ID_NO='$_GET[no]' order by createtime Desc";
// $qryc=sqlsrv_query($conn1,$sqlc, array(), array("Scrollable"=>"buffered"));

// $countdata=sqlsrv_num_rows($qryc);

// if ($countdata > 0)
// {
date_default_timezone_set('Asia/Jakarta');
 
 //
$sqlstm=mysqli_query($con,"SELECT * FROM tbl_setting_mesin where id='$_GET[idstm]'");
$rowstm=mysqli_fetch_array($sqlstm); 

$sqlm=mysqli_query($con,"SELECT kode FROM tbl_mesin where no_mesin='$rowstm[no_mc]'");
$rowm=mysqli_fetch_array($sqlm); 
 ?>
<table width="100%" border="0" class="table-list1">
  <tr>
    <td width="100%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid;" valign="middle" align="center"><strong><font size="+2" >SETTING PRODUK DYEING</font></strong></td>
  </tr>
</table>
<br>
<table width="100%" border="0" class="table-list1">
  <tr>
    <td width="10%" style="font-size:11px;" align="left"><strong>NO. ITEM</strong></td>
    <td width="20%" style="font-size:18px;" align="left"><strong><?php echo $rowstm['no_hanger'];?></strong></td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid;" align="left">&nbsp;</td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong>TANGGAL CETAK</strong></td>
    <td width="2%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="center">:</td>
    <td width="15%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong><?php if($rowstm['tgl_buat']!=""){echo date("d-M-Y",strtotime($rowstm['tgl_buat']));} ?></strong></td>
  </tr>
  <tr>
    <td width="10%" style="font-size:11px;" align="left"><strong>JENIS KAIN</strong></td>
    <td width="20%" style="font-size:11px;" align="left"><strong><?php echo $rowstm['jenis_kain'];?></strong></td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid;" align="left">&nbsp;</td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong>TES</strong></td>
    <td width="2%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="center">:</td>
    <td width="15%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong><?php echo $rowstm['jumlah_test'];?></strong></td>
  </tr>
  <tr>
    <td width="10%" style="font-size:11px;" align="left"><strong>LEBAR X GRAMASI</strong></td>
    <td width="20%" style="font-size:11px;" align="left"><strong><?php echo $rowstm['lebar'];?> X <?php echo $rowstm['gramasi'];?></strong></td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid;" align="left">&nbsp;</td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong>ORDER TES / LOT</strong></td>
    <td width="2%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="center">:</td>
    <td width="15%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong><?php echo $rowstm['no_order'];?> / <?php echo $rowstm['lot'];?></strong></td>
  </tr>
  <tr>
    <td width="10%" style="font-size:11px;" align="left"><strong>KATEGORI WARNA</strong></td>
    <td width="20%" style="font-size:11px;" align="left"><strong><?php echo $rowstm['warna'];?></strong></td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid;" align="left">&nbsp;</td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong>NO KK</strong></td>
    <td width="2%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="center">:</td>
    <td width="15%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong><?php echo $rowstm['nokk'];?></strong></td>
  </tr>
  <tr>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left">&nbsp;</td>
    <td width="20%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left">&nbsp;</td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid;" align="left">&nbsp;</td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong>NO MC TES</strong></td>
    <td width="2%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="center">:</td>
    <td width="15%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong><?php echo $rowstm['no_mc'];?></strong></td>
  </tr>
  <tr>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left">&nbsp;</td>
    <td width="20%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left">&nbsp;</td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid;" align="left">&nbsp;</td>
    <td width="10%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong>NO PO / DEMAND</strong></td>
    <td width="2%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="center">:</td>
    <td width="15%" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid; border-right:0px #000000 solid; border-left:0px #000000 solid; font-size:11px;" align="left"><strong><?php echo $rowstm['prod_order'];?> | <?php echo $rowstm['prod_demand'];?></strong></td>
  </tr>
</table>
<table width="100%" border="1" class="table-list1">
  <thead>
    <tr>
      <th align="center" rowspan="3" bgcolor="#92D050">NO. Mesin</th>
      <th align="center" rowspan="3" bgcolor="#92D050">MESIN</th>
      <th align="center" rowspan="3" bgcolor="#92D050">KAPASITAS MESIN</th>
      <th align="center" colspan="13" bgcolor="#92D050">SETTING MESIN</th>
    </tr>
    <tr>
      <th align="center" rowspan="2" bgcolor="#92D050">LOADING</th>
      <th align="center" colspan="2" bgcolor="#92D050">L : R</th>
      <th align="center" rowspan="2" bgcolor="#92D050">NO PROGRAM</th>
      <th align="center" rowspan="2" bgcolor="#92D050">RPM</th>
      <th align="center" rowspan="2" bgcolor="#92D050">CYCLE TIME</th>
      <th align="center" colspan="2" bgcolor="#92D050">TEKANAN</th>
      <th align="center" colspan="2" bgcolor="#92D050">NOZZLE</th>
      <th align="center" colspan="2" bgcolor="#92D050">BLOWER</th>
      <th align="center" rowspan="2" bgcolor="#92D050">PLAITER</th>
    </tr>
    <tr>
      <th align="center" bgcolor="#92D050">POLY</th>
      <th align="center" bgcolor="#92D050">CTN</th>
      <th align="center" bgcolor="#92D050">POLY</th>
      <th align="center" bgcolor="#92D050">CTN</th>
      <th align="center" bgcolor="#92D050">POLY</th>
      <th align="center" bgcolor="#92D050">CTN</th>
      <th align="center" bgcolor="#92D050">POLY</th>
      <th align="center" bgcolor="#92D050">CTN</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td align="center" width="5%"><?php echo $rowstm['no_mc'];?></td>
      <td align="center" width="5%"><?php echo $rowm['kode'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['kapasitas'];?> Kg</td>
      <td align="center" width="5%"><?php echo $rowstm['loading'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['l_r_poly'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['l_r'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['no_program'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['rpm'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['cycle_time'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['tekanan_poly'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['tekanan'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['nozzle_poly'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['nozzle'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['blower_poly'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['blower'];?></td>
      <td align="center" width="5%"><?php echo $rowstm['plaiter'];?></td>
    </tr>
    <tr>
      <td align="center" colspan="16">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" colspan="16">Note : <?php echo $rowstm['catatan'];?></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="1" class="table-list1">
  <tr>
    <td align="center" width="100%" bgcolor="#92D050">GRAFIK</td>
  </tr>
  <tr>
    <td align="center" width="100%"><img src="../../dist/img-settingmesin/<?php echo $rowstm['file_gambar'];?>" width="350" /></td>
  </tr>
  <br>
  <tr>
    <td align="left" width="100%"><strong>ALUR CELUP : <?php echo $rowstm['alur_proses'];?></strong></td>
  </tr>
  <tr>
    <td align="left" width="100%">NOTE:</td>
  </tr>
</table>
<table width="100%" border="" class="table-list1">
  <tr align="center" >
    <td width="16%">Dibuat Oleh :</td>
    <td width="16%">Diketahui Oleh :</td>
  </tr>
  <tr>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
    <td valign="top" style="border-bottom:0px #000000 solid; border-top:0px #000000 solid;">&nbsp;</td>
  </tr>
</table>

  <?php 
//} ?>
<script>
alert('cetak');window.print();
</script>
</body>
</html>