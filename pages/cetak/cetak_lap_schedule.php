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
$qTgl=sqlsrv_query($con,"SELECT CONVERT(varchar, GETDATE(), 23) as tgl_skrg, CONVERT(varchar, GETDATE(), 8) as jam_skrg");
$rTgl=sqlsrv_fetch_array($qTgl, SQLSRV_FETCH_ASSOC);
$Awal= $_GET['awal'];	  
$start_date = $Awal.' 07:15:00'; 
$stop_date  = date('Y-m-d', strtotime($Awal . ' +1 day')).' 07:15:00';
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
    <td width="9%" rowspan="4" align="center"><img src="indo.jpg" width="50" height="50"  /></td>
    <td width="71%" rowspan="4" valign="middle" align="center"><strong><font size="+1" >SCHEDULE PENCELUPAN, RELAXING &amp; SCOURING&#10142;PRESET</font></strong></td>
    <td width="20%"><pre>No. Form	: 14-11</pre></td>
  </tr>
  <tr>
    <td><pre>No. Revisi	: 14</pre></td>
  </tr>
  <tr>
    <td><pre>Tgl. Terbit	: 9 April 2019</pre></td>
  </tr>
  <tr>
    <td><pre>Halaman          :</pre></td>
  </tr>	
</table>
<div style="text-align: right"> Jam: <?php echo date('H:i:s', strtotime($rTgl['jam_skrg']));?></div>		  
Hari/Tanggal : <?php echo tanggal_indo ($Awal, true);?>
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
		function tampil($mc,$no,$start,$stop){
	    include "../../koneksi.php";
			$qCek=sqlsrv_query($con,"SELECT
	   	s.id,
		STRING_AGG(s.lot, '/' ) AS lot,
		CASE WHEN COUNT(s.lot)>1 THEN 'Gabung Kartu' ELSE '' END as ket_kartu,
		s.no_mesin,
		s.no_sch as no_urut,
		s.buyer,
		s.langganan,
		STUFF((
            SELECT DISTINCT '-' + s2.no_order
            FROM db_dying.tbl_schedule s2
            WHERE s2.no_sch = s.no_sch
              AND s2.no_mesin = s.no_mesin
              AND CONVERT(varchar, s2.tgl_update, 120) BETWEEN '$start' AND '$stop'
            FOR XML PATH(''), TYPE
        ).value('.', 'nvarchar(max)'), 1, 1, '') AS no_order,
		s.no_resep,
		s.nokk,
		s.jenis_kain,
		s.warna,
		s.no_warna,
		sum(s.rol) as rol,
		sum(s.bruto) as bruto,
		s.proses,
		s.ket_status,
		s.tgl_delivery,
		s.ket_kain,
		s.personil
	FROM
		db_dying.tbl_schedule s
	WHERE
	 s.no_sch='$no' AND s.no_mesin='$mc' AND CONVERT(varchar, s.tgl_update, 120) BETWEEN '$start' AND '$stop'
	GROUP BY
		s.no_mesin,
		s.no_sch,
		s.id,
		s.buyer,
		s.langganan,
		s.no_resep,
		s.nokk,
		s.jenis_kain,
		s.warna,
		s.no_warna,
		s.proses,
		s.ket_status,
		s.tgl_delivery,
		s.ket_kain,
		s.personil
	ORDER BY
		s.id ASC");
	  	$row=sqlsrv_fetch_array($qCek, SQLSRV_FETCH_ASSOC);
		$dt[]=$row;
		return $dt;

	}

   /* $data=mysqli_query("SELECT b.* from tbl_schedule a
LEFT JOIN tbl_mesin b ON a.no_mesin=b.no_mesin WHERE not a.`status`='selesai' GROUP BY a.no_mesin ORDER BY a.kapasitas DESC,a.no_mesin ASC"); */
	$data=sqlsrv_query($con,"SELECT b.* from db_dying.tbl_mesin b ORDER BY b.kapasitas DESC,b.no_mesin ASC");
	$no=1;
	$n=1;
	$c=0;
	 ?>
	<?php
	  $col=0;
  while($rowd=sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
		 ?>
    <tr>
      <td rowspan="7"><a class="hurufvertical"><h2>
        <div align="center"><?php echo $rowd['kapasitas'];?></div>
      </h2></a></td>
      <td rowspan="7"><div align="center" style="font-size: 18px;"><strong><?php echo $rowd['no_mesin'];?></strong>
		  </div><div align="center" style="font-size: 12px;">(<?php echo $rowd['kode'];?>)</div>
      </td>	  	
      <td valign="top" style="height: 0.27in;"><div align="center">1</div></td>
	  <?php foreach(tampil($rowd['no_mesin'],"1",$start_date,$stop_date) as $dd){ ?>	
      <td align="center" valign="top"><?php echo $dd['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd['jenis_kain'])>25){echo substr($dd['jenis_kain'],0,25)."...";}else{echo $dd['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd['warna'])>25){echo substr($dd['warna'],0,25)."...";}else{echo $dd['warna'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd['lot']; ?></div></td>
      <td align="center" valign="top"><?php if($dd['tgl_delivery']!="0000-00-00" && $dd['tgl_delivery']!=null){echo $dd['tgl_delivery']->format('Y-m-d');} ?></td>
      <td align="center" valign="top"><?php if($dd['rol']!="0"){echo $dd['rol'];} ?></td>
      <td align="right" valign="top"><?php if($dd['bruto']!="0"){echo $dd['bruto'];} ?></td>
      <td valign="top"><?php echo $dd['ket_status']; ?><br>
        <?php echo $dd['personil']; ?><br>        
        <?php echo $dd['ket_kain']; ?></td>
	  <?php } ?>	
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">2</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"2",$start_date,$stop_date) as $dd1){ ?>	
      <td align="center" valign="top"><?php echo $dd1['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd1['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd1['jenis_kain'])>30){echo substr($dd1['jenis_kain'],0,30)."...";}else{echo $dd1['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd1['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd1['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd1['lot']; ?></div></td>
      <td align="center" valign="top"><?php if($dd1['tgl_delivery']!=null){echo $dd1['tgl_delivery']->format('Y-m-d');} ?></td>
      <td align="center" valign="top"><?php echo $dd1['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd1['bruto']; ?></td>
      <td valign="top"><?php echo $dd1['ket_status']; ?><br>
        <?php echo $dd1['personil']; ?><br>        
        <?php echo $dd1['ket_kain']; ?></td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">3</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"3",$start_date,$stop_date) as $dd2){ ?>	
      <td align="center" valign="top"><?php echo $dd2['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd2['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd2['jenis_kain'])>30){echo substr($dd2['jenis_kain'],0,30)."...";}else{echo $dd2['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd2['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd2['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd2['lot']; ?></div></td>
      <td align="center" valign="top"><?php if($dd2['tgl_delivery']!=null && $dd2['tgl_delivery']!="0000-00-00"){echo $dd2['tgl_delivery']->format('Y-m-d');} ?></td>
      <td align="center" valign="top"><?php echo $dd2['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd2['bruto']; ?></td>
      <td valign="top"><?php echo $dd2['ket_status']; ?><br>
        <?php echo $dd2['personil']; ?><br>        
        <?php echo $dd2['ket_kain']; ?></td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">4</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"4",$start_date,$stop_date) as $dd3){ ?>	
      <td align="center" valign="top"><?php echo $dd3['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd3['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd3['jenis_kain'])>30){echo substr($dd3['jenis_kain'],0,30)."...";}else{echo $dd3['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd3['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd3['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd3['lot']; ?></div></td>
      <td align="center" valign="top"><?php if($dd3['tgl_delivery']!=null && $dd3['tgl_delivery']!="0000-00-00"){echo $dd3['tgl_delivery']->format('Y-m-d');} ?></td>
      <td align="center" valign="top"><?php echo $dd3['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd3['bruto']; ?></td>
      <td valign="top"><?php echo $dd3['ket_status']; ?><br>
        <?php echo $dd3['personil']; ?><br>        
        <?php echo $dd3['ket_kain']; ?></td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">5</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"5",$start_date,$stop_date) as $dd4){ ?>	
      <td align="center" valign="top"><?php echo $dd4['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd4['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd4['jenis_kain'])>30){echo substr($dd4['jenis_kain'],0,30)."...";}else{echo $dd4['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd4['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd4['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd4['lot']; ?></div></td>
      <td align="center" valign="top"><?php if($dd4['tgl_delivery']!=null && $dd4['tgl_delivery']!="0000-00-00"){echo $dd4['tgl_delivery']->format('Y-m-d');} ?></td>
      <td align="center" valign="top"><?php echo $dd4['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd4['bruto']; ?></td>
      <td valign="top"><?php echo $dd4['ket_status']; ?><br>
        <?php echo $dd4['personil']; ?><br>        
        <?php echo $dd4['ket_kain']; ?></td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">6</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"6",$start_date,$stop_date) as $dd5){ ?>	
      <td align="center" valign="top"><?php echo $dd5['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd5['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd5['jenis_kain'])>30){echo substr($dd5['jenis_kain'],0,30)."...";}else{echo $dd5['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd5['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd5['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd5['lot']; ?></div></td>
      <td align="center" valign="top"><?php if($dd5['tgl_delivery']!=null && $dd5['tgl_delivery']!="0000-00-00"){echo $dd5['tgl_delivery']->format('Y-m-d');} ?></td>
      <td align="center" valign="top"><?php echo $dd5['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd5['bruto']; ?></td>
      <td valign="top"><?php echo $dd5['ket_status']; ?><br>
        <?php echo $dd5['personil']; ?><br>        
        <?php echo $dd5['ket_kain']; ?></td>
	  <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.27in;"><div align="center">7</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"7",$start_date,$stop_date) as $dd6){ ?>	
      <td align="center" valign="top"><?php echo $dd6['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd6['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd6['jenis_kain'])>30){echo substr($dd6['jenis_kain'],0,30)."...";}else{echo $dd6['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd6['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd6['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd6['lot']; ?></div></td>
      <td align="center" valign="top"><?php if($dd6['tgl_delivery']!=null && $dd6['tgl_delivery']!="0000-00-00"){echo $dd6['tgl_delivery']->format('Y-m-d');} ?></td>
      <td align="center" valign="top"><?php echo $dd6['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd6['bruto']; ?></td>
      <td valign="top"><?php echo $dd6['ket_status']; ?><br>
        <?php echo $dd6['personil']; ?><br>        
        <?php echo $dd6['ket_kain']; ?></td>
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
      <td align="center">Bayu Nugraha</td>
      <td align="center">Putri</td>
      <td align="center">I Gusti Ketut Kerta</td>
      </tr>
    <tr>
      <td>Jabatan</td>
      <td align="center">Leader Planning</td>
      <td align="center">PPC Supervisor</td>
      <td align="center">Dye Ast. Manager</td>
      </tr>
    <tr>
      <td>Tanggal</td>
      <td align="center"><?php echo tanggal_indo ($Awal, false);?></td>
      <td align="center"><?php echo tanggal_indo ($Awal, false);?></td>
      <td align="center"><?php echo tanggal_indo ($Awal, false);?></td>
      </tr>
    <tr>
      <td valign="top" style="height: 0.5in;">Tanda Tangan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  
</table></td>
    </tr>
  
</table>
<br />
<div style="font-size: 11px; font-family:sans-serif, Roman, serif;">
  <?Php
    $dtKet = sqlsrv_query($con,"SELECT
      sum(CASE WHEN ket_status='Tolak Basah' THEN 1 ELSE 0 END) as tolak_basah,
      sum(CASE WHEN ket_status='Gagal Proses' THEN 1 ELSE 0 END) as gagal_proses,
      sum(CASE WHEN ket_status='perbaikan' THEN 1 ELSE 0 END) as perbaikan
    FROM
      db_dying.tbl_schedule
    WHERE
      [status] <> 'selesai'");
    $rKet = $dtKet ? sqlsrv_fetch_array($dtKet, SQLSRV_FETCH_ASSOC) : ['perbaikan'=>0,'gagal_proses'=>0,'tolak_basah'=>0];
  ?>
  Perbaikan: <?php echo $rKet['perbaikan']; ?> Lot<br />
  Gagal Proses : <?php echo $rKet['gagal_proses']; ?> Lot<br />
  Tolak Basah : <?php echo $rKet['tolak_basah']; ?> Lot </div>
<script>
//alert('cetak');window.print();
</script> 
</body>
</html>
