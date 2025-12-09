<?php 
//$lReg_username=$_SESSION['labReg_username'];
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../koneksiLAB.php";
include "../../tgl_indo.php";
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
$qTgl=mysqli_query($con,"SELECT DATE_FORMAT(now(),'%Y-%m-%d') as tgl_skrg, DATE_FORMAT(now(),'%Y-%m-%d')+ INTERVAL 1 DAY as tgl_besok");
$rTgl=mysqli_fetch_array($qTgl);
?>
<html>
<head>
<title>:: Cetak Reports Produksi Dyeing</title>
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<style>
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
        <td colspan="18"><table width="100%" border="0" class="table-list1">
          <thead>
            <tr>
              <td width="6%" rowspan="4"><img src="Indo.jpg" alt="" width="60" height="60"></td>
              <td width="75%" rowspan="4"><div align="center">
                <h2>FORM PRODUKSI HARIAN DYEING</h2>
              </div></td>
              <td width="8%">No. Form</td>
              <td width="11%">: FW-02-DYE-03</td>
            </tr>
            <tr>
              <td>No. Revisi</td>
              <td>: 06</td>
            </tr>
            <tr>
              <td>Tgl. Terbit</td>
              <td>: 01 Maret 2019</td>
            </tr>
                <thead>
        </table></td>
      </tr>
<tr valign="top">
        <td colspan="18"><strong>Periode: <?php echo $_GET['awal']; ?> s/d <?php echo $_GET['akhir']; ?></strong><br />
        <strong>Shift: <?php echo $_GET['shft']; ?></strong></td>
      </tr>
    <tr>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">NO MC</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">LANGGANAN / BUYER</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">NO ORDER</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">JENIS KAIN</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">WARNA</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">LOT</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">ROLL</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">QTY</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">PROSES</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">KETERANGAN</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">K.R</div></td>
      <td rowspan="2" bgcolor="#99FF99">R.B/R.L</td>
      <td colspan="2" bgcolor="#99FF99"><div align="center">JAM PROSES</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">POINT</div></td>
      <td colspan="2" bgcolor="#99FF99"><div align="center">STOP MESIN</div></td>
      <td rowspan="2" bgcolor="#99FF99"><div align="center">KODE STOP</div></td>
    </tr>
     <tr>
      <td bgcolor="#99FF99"><div align="center">IN</div></td>
      <td bgcolor="#99FF99"><div align="center">OUT</div></td>
      <td bgcolor="#99FF99"><div align="center">JAM</div></td>
      <td bgcolor="#99FF99"><div align="center">S/D</div></td>
    </tr>
    </thead> 
    <tbody>
	<?php
	$Awal=$_GET['awal'];
	$Akhir=$_GET['akhir'];	
	if($_GET['shft']=="ALL"){$shft=" ";}else{$shft=" a.g_shift='$_GET[shft]' AND ";}
		$sql=mysqli_query($con,"SELECT
	a.*,
	b.buyer,
	b.langganan,
	b.no_order,
	b.jenis_kain,
	b.no_mesin,
	b.warna,
	b.lot,
	c.rol,
	c.bruto,
	b.ket_status,
	c.tgl_buat as tgl_in,
	a.tgl_buat as tgl_out,
	a.kd_stop,
	a.mulai_stop,
	a.selesai_stop,
	a.ket,
	b.proses 
FROM
	tbl_montemp c
	LEFT JOIN tbl_hasilcelup a  ON a.id_montemp=c.id
	LEFT JOIN tbl_schedule b ON c.id_schedule = b.id
WHERE
	$shft 
	DATE_FORMAT( c.tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' 
ORDER BY
	b.no_mesin ASC");
  
   $no=1;
   
   $c=0;
   
    while($rowd=mysqli_fetch_array($sql)){
		   ?>
      <tr valign="top">
      <td><div align="center"><?php echo $rowd['no_mesin'];?></div></td>
      <td><?php echo $rowd['langganan']."/".$rowd['buyer'];?></td>
      <td><?php echo $rowd['no_order']; ?></td>
      <td><?php echo $rowd['jenis_kain'];?></td>
      <td><?php echo $rowd['warna']; ?></td>
      <td><div align="center"><?php echo $rowd['lot']; ?></div></td>
      <td><div align="center"><?php echo $rowd['rol']; ?></div></td>
      <td><div align="right"><?php echo $rowd['bruto']; ?></div></td>
      <td><?php echo $rowd['proses']; ?></td>
      <td><?php echo $rowd['ket']; ?></td>
      <td><?php echo $rowd['k_resep'];?></td>
      <td><div align="center"><?php if($rowd['resep']=="Baru"){echo"R.B";}else{echo"R.L";}?></div></td>
      <td><div align="right"><?php if($rowd['tgl_in']!=""){echo  date('H:i', strtotime($rowd['tgl_in']));}?></div></td>
      <td><div align="right"><?php if($rowd['tgl_out']!=""){echo  date('H:i', strtotime($rowd['tgl_out']));}?></div></td>
      <td><div align="center"><?php echo $rowd['point'];?></div></td>
      <td><div align="right"><?php if($rowd['mulai_stop']!=""){echo  date('H:i', strtotime($rowd['mulai_stop']));}?></div></td>
      <td><div align="right"><?php if($rowd['selesai_stop']!=""){echo  date('H:i', strtotime($rowd['selesai_stop']));}?></div></td>
      <td><div align="center"><?php echo $rowd['kd_stop'];?></div></td>
    </tr>
     <?php 
	 $totrol +=$rowd['rol'];
	 $totberat +=$rowd['bruto'];
	 $no++;} ?>
     </tbody>
    <tr>
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
      <td bgcolor="#99FF99">Total</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99"><div align="right"><?php echo $totrol;?></div></td>
      <td bgcolor="#99FF99"><div align="right"><?php echo $totberat;?></div></td>
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
</table>
  <table width="100%" border="0" class="table-list1">
  <tr>
    <td width="15%">&nbsp;</td>
    <td width="31%"><div align="center">DIBUAT OLEH:</div></td>
    <td width="27%"><div align="center">DIPERIKSA OLEH:</div></td>
    <td width="27%"><div align="center">DIKETAHUI OLEH:</div></td>
    </tr>
  <tr>
    <td>NAMA</td>
    <td><div align="center">
      <input name=nama type=text placeholder="Ketik disini" size="33" maxlength="30">
    </div></td>
    <td><div align="center">
      <input name=nama3 type=text placeholder="Ketik disini" size="33" maxlength="30">
    </div></td>
    <td><div align="center">
      <input name=nama5 type=text placeholder="Ketik disini" size="33" maxlength="30">
    </div></td>
    </tr>
  <tr>
    <td>JABATAN</td>
    <td><div align="center">
      <input name=nama2 type=text placeholder="Ketik disini" size="33" maxlength="30">
    </div></td>
    <td><div align="center">
      <input name=nama4 type=text placeholder="Ketik disini" size="33" maxlength="30">
    </div></td>
    <td><div align="center">
      <input name=nama6 type=text placeholder="Ketik disini" size="33" maxlength="30">
    </div></td>
    </tr>
  <tr>
    <td>TANGGAL</td>
    <td><div align="center">
      <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
    </div></td>
    <td><div align="center">
      <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
    </div></td>
    <td><div align="center">
      <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
    </div></td>
    </tr>
  <tr>
    <td height="60" valign="top">TANDA TANGAN</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>

</body>
</html>