<?php
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../tgl_indo.php";
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
$Awal=$_GET['Awal'];
$Akhir=$_GET['Akhir'];
$qTgl = sqlsrv_query(
  $con,
  "SELECT CONVERT(varchar(10), GETDATE(), 120) AS tgl_skrg,
          CONVERT(varchar(8), GETDATE(), 108) AS jam_skrg"
);
$rTgl = sqlsrv_fetch_array($qTgl, SQLSRV_FETCH_ASSOC);
if($Awal!=""){$tgl=substr($Awal,0,10); $jam=$Awal;}else{$tgl=$rTgl['tgl_skrg']; $jam=$rTgl['jam_skrg'];}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Cetak Schedule Page 13</title>
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
<?php
function format_tanggal_sqlsrv($value) {
	if ($value instanceof DateTime) {
		return $value->format('Y-m-d');
	}
	return $value;
}
?>
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
        <td width="78%"><font size="-1">Hari/Tanggal : <?php echo tanggal_indo ($tgl, true);?></font></td>
        <td width="22%" align="right">Jam: <?php echo date('H:i:s', strtotime($jam));?></td>
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
		global $con;		

		$sql = "SELECT
				MIN(id) AS id,
				STRING_AGG( lot, '/' ) AS lot,
				CASE WHEN COUNT(lot)>1 THEN 'Gabung Kartu' ELSE '' END as ket_kartu,
				no_mesin,
				no_urut,
				MAX(buyer) as buyer,
				MAX(langganan) as langganan,
				STRING_AGG(no_order, '-' ) AS no_order,
				MAX(no_resep) as no_resep,
				nokk,
        nodemand,
				MAX(jenis_kain) as jenis_kain,
				MAX(warna) as warna,
				MAX(no_warna) as no_warna,
				SUM(rol) as rol,
				SUM(bruto) as bruto,
				MAX(proses) as proses,
				MAX(ket_status) as ket_status,
				MAX(tgl_delivery) as tgl_delivery,
				STRING_AGG(personil, ',' ) AS personil,
				MAX(ket_kain) as ket_kain,
				MAX(mc_from) as mc_from
			FROM
				db_dying.tbl_schedule 
			WHERE
				status <> 'selesai' and no_urut = ? and no_mesin = ?";

		$params = array($no, $mc);

		if($awal!=""){
			$sql .= " AND tgl_update BETWEEN ? AND ?";
			$params[] = $awal;
			$params[] = $akhir;
		}

		$sql .= "
			GROUP BY
				no_mesin,
				no_urut,
        nokk,
        nodemand
			ORDER BY
				MIN(id) ASC";

		$qCek = sqlsrv_query($con, $sql, $params);
		if ($qCek === false) {
			return array();
		}
	  	$row = sqlsrv_fetch_array($qCek, SQLSRV_FETCH_ASSOC);
		$dt[]=$row;
		return $dt;
	}
   /* $data=mysqli_query("SELECT b.* from tbl_schedule a
LEFT JOIN tbl_mesin b ON a.no_mesin=b.no_mesin WHERE not a.`status`='selesai' GROUP BY a.no_mesin ORDER BY a.kapasitas DESC,a.no_mesin ASC"); */
	$data = sqlsrv_query(
		$con,
		"SELECT *
		 FROM db_dying.tbl_mesin
		 ORDER BY kapasitas DESC, no_mesin ASC
		 OFFSET 47 ROWS FETCH NEXT 4 ROWS ONLY"
	);
	$no=1;
	$n=1;
	$c=0;
	 ?>
	<?php
	  $col=0;
  while($rowd = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
		 ?>
    <tr>
      <td rowspan="7"><a class="hurufvertical"><h2>
        <div align="center"><?php echo $rowd['kapasitas'];?></div>
      </h2></a></td>
      <td rowspan="7"><div align="center" style="font-size: 18px;"><strong><?php echo $rowd['no_mesin'];?></strong>
		  </div><div align="center" style="font-size: 12px;">(<?php echo $rowd['kode'];?>)</div>
      </td>	  	
      <td valign="top" style="height: 0.35in;"><div align="center">1</div></td>
	  <?php foreach(tampil($rowd['no_mesin'],"1",$Awal,$Akhir) as $dd){ ?>	
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
      <td align="center" valign="top"><?php if($dd['tgl_delivery']!="0000-00-00"){echo format_tanggal_sqlsrv($dd['tgl_delivery']);} ?></td>
      <td align="center" valign="top"><?php if($dd['rol']!="0"){echo $dd['rol'];} ?></td>
      <td align="right" valign="top"><?php if($dd['bruto']!="0"){echo $dd['bruto'];} ?></td>
      <td valign="top"><?php echo $dd['ket_status']; ?><br />
        <?php echo $dd['personil']; ?> <?php echo $dd['ket_kain']; ?>
        <?php if($dd['mc_from']!=""){ echo " Dari MC:".$dd['mc_from'];} ?></td>
      <?php } ?>	
    </tr>
    <tr>
      <td valign="top" style="height: 0.35in;"><div align="center">2</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"2",$Awal,$Akhir) as $dd1){ ?>	
      <td align="center" valign="top"><?php echo $dd1['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd1['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd1['jenis_kain'])>30){echo substr($dd1['jenis_kain'],0,30)."...";}else{echo $dd1['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd1['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd1['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd1['lot']; ?></div></td>
      <td align="center" valign="top"><?php echo format_tanggal_sqlsrv($dd1['tgl_delivery']); ?></td>
      <td align="center" valign="top"><?php echo $dd1['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd1['bruto']; ?></td>
      <td valign="top"><?php echo $dd1['ket_status']; ?><br />
        <?php echo $dd1['personil']; ?> <?php echo $dd1['ket_kain']; ?>
        <?php if($dd1['mc_from']!=""){ echo " Dari MC:".$dd1['mc_from'];} ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.35in;"><div align="center">3</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"3",$Awal,$Akhir) as $dd2){ ?>	
      <td align="center" valign="top"><?php echo $dd2['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd2['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd2['jenis_kain'])>30){echo substr($dd2['jenis_kain'],0,30)."...";}else{echo $dd2['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd2['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd2['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd2['lot']; ?></div></td>
      <td align="center" valign="top"><?php echo format_tanggal_sqlsrv($dd2['tgl_delivery']); ?></td>
      <td align="center" valign="top"><?php echo $dd2['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd2['bruto']; ?></td>
      <td valign="top"><?php echo $dd2['ket_status']; ?><br />
        <?php echo $dd2['personil']; ?> <?php echo $dd2['ket_kain']; ?>
        <?php if($dd2['mc_from']!=""){ echo " Dari MC:".$dd2['mc_from'];} ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.35in;"><div align="center">4</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"4",$Awal,$Akhir) as $dd3){ ?>	
      <td align="center" valign="top"><?php echo $dd3['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd3['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd3['jenis_kain'])>30){echo substr($dd3['jenis_kain'],0,30)."...";}else{echo $dd3['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd3['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd3['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd3['lot']; ?></div></td>
      <td align="center" valign="top"><?php echo format_tanggal_sqlsrv($dd3['tgl_delivery']); ?></td>
      <td align="center" valign="top"><?php echo $dd3['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd3['bruto']; ?></td>
      <td valign="top"><?php echo $dd3['ket_status']; ?><br />
        <?php echo $dd3['personil']; ?> <?php echo $dd3['ket_kain']; ?>
        <?php if($dd3['mc_from']!=""){ echo " Dari MC:".$dd3['mc_from'];} ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.35in;"><div align="center">5</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"5",$Awal,$Akhir) as $dd4){ ?>	
      <td align="center" valign="top"><?php echo $dd4['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd4['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd4['jenis_kain'])>30){echo substr($dd4['jenis_kain'],0,30)."...";}else{echo $dd4['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd4['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd4['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd4['lot']; ?></div></td>
      <td align="center" valign="top"><?php echo format_tanggal_sqlsrv($dd4['tgl_delivery']); ?></td>
      <td align="center" valign="top"><?php echo $dd4['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd4['bruto']; ?></td>
      <td valign="top"><?php echo $dd4['ket_status']; ?><br />
        <?php echo $dd4['personil']; ?> <?php echo $dd4['ket_kain']; ?>
        <?php if($dd4['mc_from']!=""){ echo " Dari MC:".$dd4['mc_from'];} ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.35in;"><div align="center">6</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"6",$Awal,$Akhir) as $dd5){ ?>	
      <td align="center" valign="top"><?php echo $dd5['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd5['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd5['jenis_kain'])>30){echo substr($dd5['jenis_kain'],0,30)."...";}else{echo $dd5['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd5['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd5['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd5['lot']; ?></div></td>
      <td align="center" valign="top"><?php echo format_tanggal_sqlsrv($dd5['tgl_delivery']); ?></td>
      <td align="center" valign="top"><?php echo $dd5['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd5['bruto']; ?></td>
      <td valign="top"><?php echo $dd5['ket_status']; ?><br />
        <?php echo $dd5['personil']; ?> <?php echo $dd5['ket_kain']; ?>
        <?php if($dd5['mc_from']!=""){ echo " Dari MC:".$dd5['mc_from'];} ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td valign="top" style="height: 0.35in;"><div align="center">7</div></td>
      <?php foreach(tampil($rowd['no_mesin'],"7",$Awal,$Akhir) as $dd6){ ?>	
      <td align="center" valign="top"><?php echo $dd6['langganan']; ?></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd6['no_order']; ?></div></td>
      <td valign="top"><div style="font-size: 8px;">
        <?php if(strlen($dd6['jenis_kain'])>30){echo substr($dd6['jenis_kain'],0,30)."...";}else{echo $dd6['jenis_kain'];} ?>
      </div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd6['warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd6['no_warna']; ?></div></td>
      <td align="center" valign="top"><div style="font-size: 8px;"><?php echo $dd6['lot']; ?></div></td>
      <td align="center" valign="top"><?php echo format_tanggal_sqlsrv($dd6['tgl_delivery']); ?></td>
      <td align="center" valign="top"><?php echo $dd6['rol']; ?></td>
      <td align="right" valign="top"><?php echo $dd6['bruto']; ?></td>
      <td valign="top"><?php echo $dd6['ket_status']; ?><br />
        <?php echo $dd6['personil']; ?> <?php echo $dd6['ket_kain']; ?>
        <?php if($dd6['mc_from']!=""){ echo " Dari MC:".$dd6['mc_from'];} ?></td>
      <?php } ?>
    </tr>
  <?php
	$no++;} 
  ?>
</table></td>
    </tr>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="87%">&nbsp;</td>
      <td width="13%"><pre>No. Form	: 14-11</pre>        <pre>No. Revisi	: 15</pre>        <pre>Tgl. Terbit	: </pre>        <pre>Halaman        : 13/16</pre></td>
    </tr>
  </tbody>
</table>	
<script>
//alert('cetak');window.print();
</script> 
</body>
</html>
