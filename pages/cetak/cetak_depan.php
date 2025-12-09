<?php
//$lReg_username=$_SESSION['labReg_username'];
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../koneksiLAB.php";
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Cetak Form Tempelan Relaxing</title>
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
</head>

<body>
<?php
if($_GET['no']!=''){$ket.=" AND ID_NO='$_GET[no]' ";}else{$ket.="";}
$sqlc="select convert(char(10),CreateTime,103) as TglBonResep,convert(char(10),CreateTime,108) as JamBonResep,ID_NO,COLOR_NAME,PROGRAM_NAME,PRODUCT_LOT,VOLUME,PROGRAM_CODE,YARN as NoKK,TOTAL_WT,USER25 from ticket_title where YARN='$idkk' ".$ket." order by createtime Desc";
				 //--lot
// $qryc=sqlsrv_query($conn1,$sqlc, array(), array("Scrollable"=>"buffered"));

$countdata=sqlsrv_num_rows($qryc);

if ($countdata > 0)
{
date_default_timezone_set('Asia/Jakarta');

// $tglsvr= sqlsrv_query($conn1,"select CONVERT(VARCHAR(10),GETDATE(),105) AS  tgk");
$sr=sqlsrv_fetch_array($tglsvr);
// $sqls=sqlsrv_query($conn,"select processcontrolJO.SODID,salesorders.ponumber,processcontrol.productid,salesorders.customerid,joborders.documentno,
// salesorders.buyerid,processcontrolbatches.lotno,productcode,productmaster.color,colorno,description,weight,cuttablewidth from Joborders 
// left join processcontrolJO on processcontrolJO.joid = Joborders.id
// left join salesorders on soid= salesorders.id
// left join processcontrol on processcontrolJO.pcid = processcontrol.id
// left join processcontrolbatches on processcontrolbatches.pcid = processcontrol.id
// left join productmaster on productmaster.id= processcontrol.productid
// left join productpartner on productpartner.productid= processcontrol.productid
// where processcontrolbatches.documentno='$idkk'");
// 		$ssr=sqlsrv_fetch_array($sqls);
// 		$lgn1=sqlsrv_query($conn,"select partnername from partners where id='$ssr[customerid]'");
// 		$ssr1=sqlsrv_fetch_array($lgn1);
// 		$lgn2=sqlsrv_query($conn,"select partnername from partners where id='$ssr[buyerid]'");
// 		$ssr2=sqlsrv_fetch_array($lgn2);
// 		$itm=sqlsrv_query($conn,"select colorcode,color,productcode from productpartner where productid='$ssr[productid]' and partnerid='$ssr[customerid]'");
// 		$itm2=sqlsrv_fetch_array($itm);
//  $row=sqlsrv_fetch_array($qryc);
//  //
//  $sql=sqlsrv_query($conn,"select stockmovement.dono,stockmovement.documentno as no_doku,processcontrolbatches.documentno,lotno,customerid,
// 	processcontrol.productid ,processcontrol.id as pcid, 
//   sum(stockmovementdetails.weight) as berat,
//   count(stockmovementdetails.weight) as roll,processcontrolbatches.dated as tgllot
//    from stockmovement 
// LEFT join stockmovementdetails on StockMovement.id=stockmovementdetails.StockmovementID
// left join processcontrolbatches on processcontrolbatches.id=stockmovement.pcbid
// left join processcontrol on processcontrol.id=processcontrolbatches.pcid



// where wid='12' and processcontrolbatches.documentno='$idkk' and (transactiontype='7' or transactiontype='4')
// group by stockmovement.DocumentNo,processcontrolbatches.DocumentNo,processcontrolbatches.LotNo,stockmovement.dono,
// processcontrol.CustomerID,processcontrol.ProductID,processcontrol.ID,processcontrolbatches.Dated") or die("gagal");
// $c=0;
//  $r=sqlsrv_fetch_array($sql); 
// 	 $sqlkko=sqlsrv_query($conn,"select SODID from knittingorders  
// 	where knittingorders.Kono='$r[dono]'") or die("gagal");
// 	$rkko=sqlsrv_fetch_array($sqlkko);
// 	 $sqlkko1=sqlsrv_query($conn,"select joid,productid from processcontroljo  
// 	where sodid='$rkko[SODID]'") or die("gagal");
// 	$rkko1=sqlsrv_fetch_array($sqlkko1);
// 	if($r['productid']!=''){$kno1=$r['productid'];}else{$kno1=$rkko1['productid'];}
// 	$sql1=sqlsrv_query($conn,"select hangerno,color from  productmaster
// 	where id='$kno1'") or die("gagal"); 
// 	 $r1=sqlsrv_fetch_array($sql1);
// 	 $sql2=sqlsrv_query($conn,"select partnername from Partners
// 	where id='$r[customerid]'") or die("gagal"); 
// 	 $r2=sqlsrv_fetch_array($sql2);
// 	 $sql3=sqlsrv_query($conn,"select Kono,joid from processcontroljo 
// 	where pcid='$r[pcid]'") or die("gagal"); 
// 	$r3=sqlsrv_fetch_array($sql3);
// 	if($r3['Kono']!=''){$kno=$r3['Kono'];}else{$kno=$r['dono'];}
// 	 $sql4=sqlsrv_query($conn,"select CAST(TM.dbo.knittingorders.[Note] AS VARCHAR(8000))as note,id,supplierid from knittingorders 
// 	where kono='$kno'") or die("gagal");
// 	 $r4=sqlsrv_fetch_array($sql4);
// 	 $sql5=sqlsrv_query($conn,"select partnername from partners 
// 	where id='$r4[supplierid]'") or die("gagal");
// 	 $r5=sqlsrv_fetch_array($sql5);
// 	 if($r3['joid']!=''){$jno=$r3['joid'];}else{$jno=$rkko1['joid'];}
// 	 $sql6=sqlsrv_query($conn,"select documentno,soid from joborders 
// 	where id='$jno'") or die("gagal");
// 	 $r6=sqlsrv_fetch_array($sql6);
// 	  $sql8=sqlsrv_query($conn,"select customerid from salesorders where id='$r6[soid]'") or die("gagal");
// 	 $r8=sqlsrv_fetch_array($sql8);
// 	 $sql9=sqlsrv_query($conn,"select partnername from partners where id='$r8[customerid]'") or die("gagal");
// 	 $r9=sqlsrv_fetch_array($sql9);
// 	 $sql10=sqlsrv_query($conn,"select id,productid from kodetails where koid='$r4[id]'") or die("gagal");
// 	 $r10=sqlsrv_fetch_array($sql10);
// 	 $sql11=sqlsrv_query($conn,"select productnumber from productmaster where id='$r10[productid]'") or die("gagal");
// 	 $r11=sqlsrv_fetch_array($sql11);
	 
	 
// 	 $s4=sqlsrv_query($conn,"select KOdetails.id as KODID,productmaster.id as BOMID ,KnittingOrders.SupplierID,TM.dbo.Partners.PartnerName,ProductNumber,CustomerID,SODID,KnittingOrders.ID as KOID,SalesOrders.ID as SOID from 
// (TM.dbo.KnittingOrders 
// left join TM.dbo.SODetails on TM.dbo.SODetails.ID= TM.dbo.KnittingOrders.SODID
// left join TM.dbo.KODetails on TM.dbo.KODetails.KOid= TM.dbo.KnittingOrders.ID
// left join TM.dbo.Partners on TM.dbo.Partners.ID= TM.dbo.KnittingOrders.SupplierID)
// left join TM.dbo.ProductMaster on TM.dbo.ProductMaster.ID= TM.dbo.KODetails.ProductID
// left join TM.dbo.SalesOrders on TM.dbo.SalesOrders.ID= TM.dbo.SODetails.SOID
// 		where KONO='$kno'");
// 	 $as7=sqlsrv_fetch_array($s4);
// 	 $sql12=sqlsrv_query($conn,"select SODetailsBom.ProductID from SODetailsBom where SODID='$as7[SODID]' and KODID='$as7[KODID]' and Parentproductid='$as7[BOMID]' order by ID", array(), array("Scrollable"=>"buffered"));
// 	  $sql14=sqlsrv_query($conn,"select  count(lotno)as jmllot from processcontrolbatches where pcid='$r[pcid]' and dated='$r[tgllot]'");
// 	  $lt=sqlsrv_fetch_array($sql14);
// 	 $ai=sqlsrv_num_rows($sql12);
// 	 $sql15=sqlsrv_query($conn,"select Partnername from TM.dbo.Partners where TM.dbo.Partners.ID='$as7[CustomerID]'");
// 	$as8=sqlsrv_fetch_array($sql15);
$i=0;



 do{
	// $as5=sqlsrv_fetch_array($sql12);
	// $sql13=sqlsrv_query($conn,"select ShortDescription from  ProductMaster where ID='$as5[ProductID]'");
	// $as6=sqlsrv_fetch_array($sql13);
	// $ar[$i]=$as6['ShortDescription'];

$i++;
}while($ai>=$i);
$jb1=$ar[0];
$jb2=$ar[1];
$jb3=$ar[2];
$jb4=$ar[3];
if($ai<2){$jb1=$ar[0];
$jb2='';
$jb3='';
}
 
 //
$sqlsmp=mysqli_query($con,"select * from tbl_schedule where id='$_GET[ids]'");
$rowsmp=mysqli_fetch_array($sqlsmp);
$sqlsmp1=mysqli_query($con,"select * from tbl_montemp where id='$_GET[idm]'");
$rowsmp1=mysqli_fetch_array($sqlsmp1);	
 ?>
<table width="100%" border="1" class="table-list1">
  <tr>
    <td width="15%" rowspan="3" align="center"><img src="logo.jpg" width="50" height="50"  /></td>
    <td width="56%" rowspan="3" valign="middle" align="center"><strong><font size="+1" >FORM TEMPELAN RELAXING</font></strong></td>
    <td width="29%"><pre>No. Form	: -</pre></td>
  </tr>
  <tr>
    <td><pre>No. Revisi	: -</pre></td>
  </tr>
  <tr>
    <td><pre>Tgl. Terbit	: -</pre></td>
  </tr>
</table>
<br />
<table width="100%" border="" class="table-list1">
  <tr height="10 cm">
    <td width="11%" style="border-right: 0px;">No Kartu Kerja</td>
    <td width="61%" style="border-left: 0px;">: <?php echo $_GET['idkk'];?></td>
    <td width="14%" style="border-right: 0px;">Tanggal	Proses</td>
    <td width="14%" style="border-left: 0px;">: 
    <?php if($rowsmp['tgl_buat']==''){echo date("d-m-Y",strtotime($rowsmp['tgl_update']));}else{echo date("d-m-Y",strtotime($rowsmp['tgl_buat']));}?></td>
  </tr>
  <tr>
    <td style="border-right: 0px;">Pelanggan</td>
    <td style="border-left: 0px;">: 
    <?php if($ssr1['partnername']!=""){echo strtoupper($ssr1['partnername']."/".$ssr2['partnername']);}else{ echo $rowsmp['langganan'];}?></td>
    <td style="border-right: 0px;">Jam Masuk Kain</td>
    <td style="border-left: 0px;">: 
    <?php if($rowsmp1['tgl_buat']!=""){echo date('H:i',strtotime($rowsmp1['tgl_buat']));}?></td>
  </tr>
  <tr>
    <td style="border-right: 0px;">No. PO</td>
    <td style="border-left: 0px;">: 
    <?php
		// $potb=sqlsrv_query("select PONumber from sodetailsadditional where sodid='$ssr[SODID]'") or die("gagal");
$rpotb=sqlsrv_fetch_array($potb);?>      <?php if($rpotb['PONumber']!=""){echo strtoupper($rpotb['PONumber']);}else{ echo $rowsmp['po']; } ?></td>
    <td style="border-right: 0px;"> No. Bon Resep</td>
    <td style="border-left: 0px;">: <?php echo $rowsmp['no_resep'];?></td>
  </tr>
  <tr>
    <td style="border-right: 0px;">No. Order</td>
    <td style="border-left: 0px;">: 
    <?php if($ssr['documentno']!=""){echo strtoupper($ssr['documentno']);}else{echo $rowsmp['no_order'];}?></td>
    <td style="border-right: 0px;">No. Program</td>
    <td style="border-left: 0px;">: <?php echo $rowsmp1['no_program'];?></td>
  </tr>
  <tr>
    <td style="border-right: 0px;">No. Warna</td>
    <td style="border-left: 0px;">: 
    <?php if($ssr['colorno']!=""){echo strtoupper($ssr['colorno']);}else{echo $rowsmp['no_warna'];}?></td>
    <td valign="top" style="border-right: 0px;">Panjang Kain (m)</td>
    <td valign="top" style="border-left: 0px;">: <?php echo $rowsmp1['pjng_kain'];?></td>
  </tr>
  <tr>
    <td style="border-right: 0px;">Warna</td>
    <td style="border-left: 0px;">: 
    <?php if($ssr['color']!=""){echo strtoupper($ssr['color']);}else{ echo $rowsmp['warna'];}?></td>
    <td valign="top" style="border-right: 0px;">Lebar x Gramasi In</td>
    <td valign="top" style="border-left: 0px;">: <?php echo $rowsmp1['lebar_a'];?> x <?php echo $rowsmp1['gramasi_a'];?></td> 
   
  </tr>
  <tr>
    <td align="left" valign="top" style="border-right: 0px;">Jenis Kain</td>
    <td align="left" valign="top" style="border-left: 0px;">: 
    <?php if($ssr['productcode']!="") {echo strtoupper($ssr['productcode']." / ".$ssr['description']);}else{ echo $rowsmp['no_item']."/".$rowsmp['jenis_kain']; }?></td>
    <td align="left" valign="top" style="border-right: 0px;"> Lebar x Gramasi Out </td>
    <td align="left" valign="top" style="border-left: 0px;">: <?php echo $rowsmp1['lebar_s'];?> x <?php echo $rowsmp1['gramasi_s'];?></td>
  </tr>
  <tr>
    <td valign="top" style="border-right: 0px;">Lot</td>
    <td valign="top" style="border-left: 0px;">: <?php echo $row['PRODUCT_LOT'];?></td>
    <td align="left" valign="top" style="border-right: 0px;">Susut Lebar (%)</td>
    <td align="left" valign="top" style="border-left: 0px;">: <?php echo $rowsmp1['susut_lebar'];?></td>
  </tr>
  <tr>
    <td valign="top" style="border-right: 0px;">Lebar	x Gramasi</td>
    <td valign="top" style="border-left: 0px;">: <?php echo number_format($ssr['cuttablewidth']); ?> x <?php echo number_format($ssr['weight']); ?></td>
    <td align="left" valign="top" style="border-right: 0px;">Susut Panjang (%)</td>
    <td align="left" valign="top" style="border-left: 0px;">: <?php echo $rowsmp1['susut_panjang'];?></td>
  </tr>
  <tr>
    <td valign="top" style="border-right: 0px;">Roll x Quantity</td>
    <td valign="top" style="border-left: 0px;">: <?php echo $rowsmp1['rol']; ?> x <?php echo $rowsmp1['bruto'];?></td>
    <td align="left" valign="top" style="border-right: 0px;">Speed (m/mnt)</td>
    <td align="left" valign="top" style="border-left: 0px;">: <?php echo $rowsmp1['speed'];?></td>
  </tr>
  <tr>
    <td valign="top" style="border-right: 0px;">Benang</td>
    <td valign="top" style="border-left: 0px;">: <font size="-6">
      <?php $bng=$jb1.",".$jb2.",".$jb3.",".$jb4;echo strtoupper($bng);?>
    </font></td>
    <td align="left" valign="top" style="border-right: 0px;">Vacuum Pump (Hz)</td>
    <td align="left" valign="top" style="border-left: 0px;">: <?php echo $rowsmp1['vacum'];?></td>
  </tr>
  <tr>
    <td valign="top" style="border-right: 0px;">Standar Cocok Warna</td>
    <td valign="top" style="border-left: 0px;">: <?php echo strtoupper($rowsmp1['std_cok_wrn']);?></td>
    <td align="left" valign="top" style="border-right: 0px;">Nama Operator</td>
    <td align="left" valign="top" style="border-left: 0px;">: <?php echo $rowsmp1['operator']; ?></td>
  </tr>
</table>
<table width="100%" border="1" class="table-list1">
  <tr align="center">
    <td colspan="8" ><strong>Setting</strong></td>
  </tr>
  <tr >
    <td width="16%" align="center">Chamber</td>
    <td width="12%" align="center">1</td>
    <td width="12%" align="center">2</td>
    <td width="12%" align="center">3</td>
    <td width="12%" align="center">4</td>
    <td width="12%" align="center">5</td>
    <td width="12%" align="center">6</td>
    <td width="12%" align="center">&nbsp;</td>
  </tr>
  <tr >
    <td align="center">Suhu (&deg;C)</td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['ch1'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['ch2'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['ch3'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['ch4'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['ch5'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['ch6'];?></span></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr >
    <td rowspan="6" align="center" valign="middle">VR</td>
    <td align="center">1</td>
    <td align="center">2</td>
    <td align="center">3</td>
    <td align="center">4</td>
    <td align="center">5</td>
    <td align="center">6</td>
    <td align="center">7</td>
  </tr>
  <tr >
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr1'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr2'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr3'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr4'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr5'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr6'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr7'];?></span></td>
  </tr>
  <tr >
    <td align="center">8</td>
    <td align="center">9</td>
    <td align="center">10</td>
    <td align="center">11</td>
    <td align="center">12</td>
    <td align="center">13</td>
    <td align="center">14</td>
  </tr>
  <tr >
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr8'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr9'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr10'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr11'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr12'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr13'];?></span></td>
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr14'];?></span></td>
  </tr>
  <tr >
    <td align="center">15</td>
    <td colspan="6" rowspan="2" align="left" valign="top">Catatan : <span style="border-left: 0px;"><?php echo $rowsmp1['ket'];?></span></td>
  </tr>
  <tr >
    <td align="center"><span style="border-left: 0px;"><?php echo $rowsmp1['vr15'];?></span></td>
  </tr>
</table>	
<table width="100%" border="1" class="table-list1">
  <tr align="center">
    <td width="17%" ><strong>Sample Kain Sebelum Proses</strong></td>
    <td width="17%" ><strong>Sample Kain Sesudah Proses</strong></td>
  </tr>
  <tr >
    <td style="height: 7.3in;">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<?php 
echo date("d-m-Y H:i:s",strtotime($rowsmp1['tgl_buat']));
} ?>
<script>
alert('cetak');window.print();
</script> 
</body>
</html>