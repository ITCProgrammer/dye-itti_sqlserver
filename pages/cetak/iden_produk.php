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
<title>Cetak Form Tempelan Sample Celup</title>
<script>

</script>
	<style>
	.table-list td {
	color: #333;
	font-size:12px;
	border-color: #fff;
	border-collapse: collapse;
	vertical-align: center;
	padding: 3px 5px;
	border-bottom:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;

	
}
.table-list1 {
	clear: both;
	text-align: left;
	border-collapse: collapse;
	margin: 0px 0px 5px 0px;
	background:#fff;	
}
.table-list1 td {
	color: #333;
	font-size:14px;
	border-color: #fff;
	border-collapse: collapse;
	vertical-align: center;
	padding: 1px 3px;
	border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;
	
	
}

	</style>
</head>

<body>
<?php
if($_GET['no']!=''){$ket.=" AND ID_NO='$_GET[no]' ";}else{$ket.="";}
$sqlc="select convert(char(10),CreateTime,103) as TglBonResep,convert(char(10),CreateTime,108) as JamBonResep,ID_NO,COLOR_NAME,PROGRAM_NAME,PRODUCT_LOT,VOLUME,PROGRAM_CODE,YARN as NoKK,TOTAL_WT,USER25 from ticket_title where YARN='$idkk' ".$ket." order by createtime Desc";
				 //--lot
// $qryc=sqlsrv_query($conn1,$sqlc, array(), array("Scrollable"=>"buffered"));

// $countdata=sqlsrv_num_rows($qryc);

if ($countdata > 0)
{
date_default_timezone_set('Asia/Jakarta');

// $tglsvr= sqlsrv_query($conn1,"select CONVERT(VARCHAR(10),GETDATE(),105) AS  tgk");
// $sr=sqlsrv_fetch_array($tglsvr);
// $sqls=sqlsrv_query($conn,"select processcontrolJO.SODID,salesorders.ponumber,processcontrol.productid,salesorders.customerid,joborders.documentno,
// salesorders.buyerid,processcontrolbatches.lotno,productcode,productmaster.color,hangerno,colorno,description,weight,cuttablewidth from Joborders 
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
//  $dated = $r['tgllot']->format('Y-m-d H:i:s'); 
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
// 	  $sql14=sqlsrv_query($conn,"select count(lotno)as jmllot from processcontrolbatches where pcid='$r[pcid]' and dated='$dated'");
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
$sqlsmp2=mysqli_query($con,"select * from tbl_hasilcelup where id_montemp='$_GET[ids]'");
$rowsmp2=mysqli_fetch_array($sqlsmp2);	
 ?>
<br />
<br />
<table width="100%" border="" class="table-list1" style="border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">
  <tr>
    <td width="10%" align="center"><img src="Indo.jpg" width="50" height="50
		" alt=""/></td>
    <td width="58%" align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;"><strong><font size="+2">IDENTIFIKASI PRODUK</font></strong></td>
    <td width="32%" align="center"><table width="100%">
      <tbody>
        <tr>
          <td width="36%" style="border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;">No. Form</td>
          <td width="5%" style="border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;">:</td>
          <td width="59%" style="border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;">20-03</td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;">No Revisi</td>
          <td style="border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;">:</td>
          <td style="border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;">02</td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;">Tgl. Terbit</td>
          <td style="border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;">:</td>
          <td style="border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;">15-04-20</td>
        </tr>
      </tbody>
    </table></td>
  </tr>
</table>
<table width="100%" border="" class="table-list1" >
  <tbody>
    <tr>
      <td colspan="3" scope="col" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;"><table width="83" border="" class="table-list1">
        <tbody>
          <tr>
            <td align="center" valign="middle"><strong>FORM A</strong></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td style="height: 0.3in;">DEPARTEMEN</td>
      <td>: DYE</td>
      <td width="37%" rowspan="6" valign="top"><table width="100%">
        <tbody>
          <tr align="center">
            <td colspan="2" scope="col">DEPARTEMEN TUJUAN :</td>
            </tr>
          <tr>
            <td width="7%" style="border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
            <td width="93%">GKG</td>
            </tr>
          <tr>
            <td style="border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
            <td>LAB</td>
            </tr>
          <tr>
            <td style="border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
            <td>DYE</td>
            </tr>
          <tr>
            <td style="border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
            <td>BRS</td>
            </tr>
          <tr>
            <td style="border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
            <td>FIN</td>
            </tr>
          <tr>
            <td style="border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
            <td>PRT</td>
            </tr>
          <tr>
            <td style="border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
            <td>QCF</td>
            </tr>
          </tbody>
      </table></td>
    </tr>
    <tr>
      <td style="height: 0.3in;">TANGGAL OUT</td>
      <td>:
        <?php 
if($rowsmp2['tgl_buat']!=""){echo date("d-m-Y",strtotime($rowsmp2['tgl_buat']));}
 ?></td>
    </tr>
    <tr>
      <td style="height: 0.3in;">NO. ORDER</td>
      <td>:
        <?php if($ssr['documentno']!=""){echo strtoupper($ssr['documentno']);}else{echo $rowsmp['no_order'];}?></td>
    </tr>
    <tr>
      <td style="height: 0.3in;">HANGER</td>
      <td>:
        <?php if($ssr['hangerno']!=""){echo strtoupper($ssr['hangerno']);}else{echo $rowsmp['no_hanger'];}?></td>
    </tr>
    <tr>
      <td style="height: 0.3in;">WARNA</td>
      <td>:
        <?php if($ssr['color']!=""){echo strtoupper($ssr['color']);}else{ echo $rowsmp['warna'];}?></td>
    </tr>
    <tr>
      <td style="height: 0.3in;">LOT</td>
      <td>: <?php echo $row['PRODUCT_LOT'];?></td>
    </tr>
    <tr>
      <td style="height: 0.3in;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="height: 0.4in;">KODE STATUS</td>
      <td>:</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="height: 0.4in;">NO GEROBAK</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="100%" border="0">
        <tbody>
          <tr>
            <td scope="col" style="height: 0.4in;">1.</td>
            <td scope="col">2.</td>
            <td scope="col">3.</td>
            <td scope="col">4.</td>
            <td scope="col">5.</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td style="height: 0.3in;">KETERANGAN</td>
      <td style="height: 0.3in;">: </td>
      <td style="height: 0.3in;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="right">&nbsp;</td>
    </tr>
  </tbody>
</table>
<br />
<?php 
//echo date("d-m-Y H:i:s",strtotime($rowsmp1['tgl_buat']));
} ?>
<script>
alert('cetak');window.print();
</script> 
</body>
</html>