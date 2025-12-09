<?php
ini_set("error_reporting", 1);
//$lReg_username=$_SESSION['labReg_username'];

//$host1="svr4";
//$username1="timdit";
//$password1="4dm1n";
//$db_name1="TM";
//set_time_limit(600);
//$conn1=mssql_connect($host1,$username1,$password1) or die ("Sorry our web is under maintenance. Please visit us later");
//$db=mssql_select_db($db_name1) or die ("Under maintenance");
//include "../../koneksiLAB.php";
//db_connect($db_name);
include "../../koneksi.php";
include "../../tgl_indo.php";
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
$Awal=$_GET['Awal'];
$Akhir=$_GET['Akhir'];
$qTgl=mysqli_query($con,"SELECT DATE_FORMAT(now(),'%Y-%m-%d') as tgl_skrg,DATE_FORMAT(now(),'%H:%i:%s') as jam_skrg");
$rTgl=mysqli_fetch_array($qTgl);
if($Awal!=""){$tgl=substr($Awal,0,10); $jam=$Awal;}else{$tgl=$rTgl['tgl_skrg']; $jam=$rTgl['jam_skrg'];}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Cetak Schedule</title>
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
.hurufvertical {
 writing-mode:tb-rl;
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform:rotate(-90deg);
    transform: rotate(180deg);
    white-space:nowrap;
    float:left;
}	

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
<table width="100%">
  <thead>
    <tr>
      <td><table width="100%" border="1" class="table-list1"> 
  <tr>
    <td width="9%" align="center"><img src="indo.jpg" width="40" height="40"  /></td>
    <td align="center" valign="middle"><strong><font size="+1" >SCHEDULE PENCELUPAN, RELAXING &amp; SCOURING&#10142;PRESET</font></strong></td>
	</tr>
  </table>
<table width="100%" border="0">
    <tbody>
      <tr>
        <td width="78%"><font size="-1">Hari/Tanggal : </font></td>
        <td width="22%" align="right">Jam: </td>
      </tr>
    </tbody>
  </table>
		</td>
    </tr>
	</thead>
    <tr>
      <td><table width="100%" border="1" class="table-list1">
	<thead>	  
    <tr>
      <td width="5%" rowspan="2" scope="col"><div align="center">Kapasitas Mesin</div></td>
      <td width="4%" rowspan="2" scope="col"><div align="center">Nomor<br>Mesin</div></td>
      <td width="3%" rowspan="2" scope="col"><div align="center">No. Urut</div></td>
      <td width="15%" rowspan="2" scope="col"><div align="center">Pelanggan</div></td>
      <td width="8%" rowspan="2" scope="col"><div align="center">No. Order</div></td>
      <td width="12%" rowspan="2" scope="col"><div align="center">Jenis Kain</div></td>
      <td width="9%" rowspan="2" scope="col"><div align="center">Warna</div></td>
      <td width="9%" rowspan="2" scope="col"><div align="center">No. Warna</div></td>
      <td width="4%" rowspan="2" scope="col"><div align="center">No Demand</div></td>
      <td width="4%" rowspan="2" scope="col"><div align="center">Lot</div></td>
      <td width="7%" rowspan="2" scope="col"><div align="center">Tanggal Delivery</div></td>
      <td colspan="2" scope="col"><div align="center">Quantity</div></td>
      <td width="14%" rowspan="2" scope="col"><div align="center">Keterangan</div></td>
    </tr>
    <tr>
      <td width="4%"><div align="center">Roll</div></td>
      <td width="6%"><div align="center">Kg</div></td>
    </tr>
		  </thead>
	<?php
	function tampil($mc,$no,$awal,$akhir){	
    include "../../koneksi.php";
		if($awal!=""){$where=" AND DATE_FORMAT( tgl_update, '%Y-%m-%d %H:%i:%s' ) BETWEEN '$awal' AND '$akhir' ";}
		else{$where=" ";}
		$qCek=mysqli_query($con,"SELECT
   	id,
	GROUP_CONCAT( lot SEPARATOR '/' ) AS lot,
	if(COUNT(lot)>1,'Gabung Kartu','') as ket_kartu,
	no_mesin,
	no_urut,
	buyer,
	langganan,
	GROUP_CONCAT(DISTINCT no_order SEPARATOR '-' ) AS no_order,
	no_resep,
	nokk,
	jenis_kain,
	warna,
	no_warna,
	sum(rol) as rol,
	sum(bruto) as bruto,
	proses,
	ket_status,
	tgl_delivery,
	ket_kain,
	mc_from,
	GROUP_CONCAT(DISTINCT personil SEPARATOR ',' ) AS personil
FROM
	tbl_schedule 
WHERE
	(`status` = 'antri mesin' or `status` = 'sedang jalan') and no_urut='$no' and no_mesin='$mc' $where
GROUP BY
	no_mesin,
	no_urut 
ORDER BY
	id ASC");
	  	$row=mysqli_fetch_array($qCek);
		$dt[]=$row;
		return $dt;
					
	}
   /* $data=mysqli_query("SELECT b.* from tbl_schedule a
LEFT JOIN tbl_mesin b ON a.no_mesin=b.no_mesin WHERE not a.`status`='selesai' GROUP BY a.no_mesin ORDER BY a.kapasitas DESC,a.no_mesin ASC"); */
	//$data=mysqli_query("SELECT b.* from tbl_mesin b ORDER BY b.kapasitas DESC,b.no_mesin ASC");
	$data=mysqli_query($con,"SELECT b.* from tbl_mesin b ORDER BY b.kapasitas DESC,b.no_mesin ASC");	  
	$no=1;
	$n=1;
	$c=0;
	 ?>
	<?php
	  $col=0;
  while($rowd=mysqli_fetch_array($data)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
		 ?>
    <tr>
      <td rowspan="7"><a class="hurufvertical"><h2>
        <div align="center"><?php echo $rowd['kapasitas'];?></div>
      </h2></a></td>
      <td rowspan="7"><div align="center" style="font-size: 18px;"><strong><?php echo $rowd['no_mesin_baru'];?></strong>
		  </div><div align="center" style="font-size: 12px;">(<?php echo $rowd['kode'];?>)</div>
      </td>	  	
      <td valign="top" style="height: 0.27in;"><div align="center">1</div></td>
	  <?php foreach(tampil($rowd['no_mesin'],"1",$Awal,$Akhir) as $dd){ ?>	
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
	  <?php } ?>	
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">2</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"2",$Awal,$Akhir) as $dd1){ ?>	
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">3</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"3",$Awal,$Akhir) as $dd2){ ?>	
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">4</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"4",$Awal,$Akhir) as $dd3){ ?>	
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">5</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"5",$Awal,$Akhir) as $dd4){ ?>	
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">6</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"6",$Awal,$Akhir) as $dd5){ ?>	
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">7</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"7",$Awal,$Akhir) as $dd6){ ?>	
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
	  <?php } ?>
    </tr>
  <?php
	$no++;} 
  ?>
</table></td>
    </tr>
    <tr>
      <td><table width="100%" border="1" class="table-list1">
  
    <tr>
      <td width="16%" scope="col">&nbsp;</td>
      <td width="29%" scope="col"><div align="center">Dibuat Oleh</div></td>
      <td width="29%" scope="col"><div align="center">Disetujui Oleh</div></td>
      <td width="26%" scope="col"><div align="center">Diketahui Oleh</div></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      </tr>
    <tr>
      <td>Jabatan</td>
      <td align="center">Leader Planning</td>
      <td align="center">PPC Ast. Manager</td>
      <td align="center">Dye Ast. Manager</td>
      </tr>
    <tr>
      <td>Tanggal</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      </tr>
    <tr>
      <td valign="top" style="height: 0.5in;">Tanda Tangan</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
  
</table></td>
    </tr>
  
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="73%" rowspan="4"><div style="font-size: 11px; font-family:sans-serif, Roman, serif;">
        <?Php $dtKet=mysqli_query($con,"SELECT
   	sum(if(ket_status='Tolak Basah',1,0)) as tolak_basah,
	  sum(if(ket_status='Gagal Proses',1,0)) as gagal_proses,
		sum(if(ket_status='perbaikan',1,0)) as perbaikan	
FROM
	tbl_schedule 
WHERE
	NOT STATUS = 'selesai'");
		$rKet=mysqli_fetch_array($dtKet);?>  
        Perbaikan: 0 Lot &nbsp; 0 Kg<br />
Gagal Proses : 0 Lot &nbsp; 0 Kg<br />
Greige : 0 Lot &nbsp; 0 Kg<br />
Tolak Basah : 0 Lot &nbsp; 0 Kg </div></td>
      <td width="20%"><pre>No. Form 	: 14-11</pre></td>
    </tr>
    <tr>
      <td><pre>No. Revisi	: 21</pre></td>
    </tr>
    <tr>
      <td><pre>Tgl. Terbit	: </pre></td>
    </tr>
    <tr>
      <td><pre></pre></td>
    </tr>
  </tbody>
</table>
<script>
//alert('cetak');window.print();
</script> 
</body>
</html>