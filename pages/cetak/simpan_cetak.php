<?php
//$lReg_username=$_SESSION['labReg_username'];
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../koneksiLAB.php";
//--
if($_REQUEST['kk']!='')
{$idkk=$_REQUEST['kk'];}else{$idkk=$_GET['idkk'];$idno=$_GET['no'];}
//-
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Cetak Bon Resep</title>
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
<h2 align="center">BON RESEP</h2>
<?php
if($idno!=''){$ket.=" AND ID_NO='$idno' ";}else{$ket.="";}
$sqlc="select convert(char(10),CreateTime,103) as TglBonResep,convert(char(10),CreateTime,108) as JamBonResep,ID_NO,COLOR_NAME,PROGRAM_NAME,PRODUCT_LOT,VOLUME,PROGRAM_CODE,YARN as NoKK,TOTAL_WT,USER25,USER28 from ticket_title where YARN='$idkk' ".$ket." order by createtime Desc";
				 //--lot
// $qryc=sqlsrv_query($conn1,$sqlc, array(), array("Scrollable"=>"buffered"));

// $countdata=sqlsrv_num_rows($qryc);
// $row=sqlsrv_fetch_array($qryc);
if ($countdata > 0)
{ 						
echo "<table width=100%>";
echo "<tr><td colspan='2' align=left >Printout : $row[TglBonResep] $row[JamBonResep] </td><td colspan='2' align=right > Type : $row[ID_NO]</td></tr></table>";
echo"<hr>";
echo "<table>";
echo "<tr><td width=150>Color Name </td><td width=250>: $row[COLOR_NAME]</td><td width=150>Program Code </td><td>: $row[PROGRAM_CODE] </td></tr>";
echo "<tr><td>Program Name </td><td>: $row[PROGRAM_NAME]</td><td width=150>Nomor KK</td><td>: $idkk</td></tr>";
echo "<tr><td>Lots </td><td>: $row[PRODUCT_LOT]</td><td>Total Wt (Kg)</td><td>: $row[TOTAL_WT]</td></tr>";
echo "<tr><td>Volume (Litres) </td><td>: $row[VOLUME]</td><td>Carry Over </td><td>: $row[USER25] </td></tr>";
echo "<tr><td>RCode</td><td>: $row[USER28] </td></tr>";
echo"</table>";
echo "<hr>";	

	$sqlstep="select distinct(STEP_NO),RECIPE_CODE from Ticket_detail where ID_No='$row[ID_NO]' order by Step_NO asc";
	// $qrystep=sqlsrv_query($conn1,$sqlstep);
	
	// while ($rowst=sqlsrv_fetch_array($qrystep)){
		
	 echo "Step $rowst[STEP_NO] Recipe Code: $rowst[RECIPE_CODE]<br>";
	 
	 	$sqlisi="select ID_NO,STEP_NO,RECIPE_CODE,PRODUCT_CODE,CONC,CONCUNIT,TARGET_WT,REMARK from Ticket_detail 
where ID_No='$row[ID_NO]' and STEP_NO='$rowst[STEP_NO]' order by Step_NO Desc";
		// $qryisi=sqlsrv_query($conn1,$sqlisi);
		  	
			echo " <table width='80%' border='0'>";
			// while ($rowisi=sqlsrv_fetch_array($qryisi)){
			  echo "  <tr>";
			  echo "   <td class='normal333' width=60><div align='left'>$rowisi[PRODUCT_CODE]</div></td>";
			 
			 		// $sqlp=sqlsrv_query($conn1,"Select ProductName from Product where ProductCode='$rowisi[PRODUCT_CODE]'");
					// $qryp=sqlsrv_fetch_array($sqlp);
					
			  echo "   <td class='normal333' width=300><div align='left'>$qryp[ProductName] </div></td>";
			  
			  		if ($rowisi['CONCUNIT']==0){
						$unit1="%";
						$unit2="g";
						$berat=$rowisi['TARGET_WT'];
					}else{
						$unit1="g/L";
						$unit2="Kg";
						//---hitung  berat
						$berat=$rowisi['TARGET_WT']/1000;
						$berat="".number_format($berat,3)."";
					}	
			  echo "   <td class='normal333' width=100><div align='right'>$rowisi[CONC] $unit1</div></td>";
			   
			   echo "   <td class='normal333' width=100><div align='right'>$berat $unit2</div></td>";
				  echo "<td class='normal333' width=100><div align='left'>$rowisi[REMARK]</div></td>";
				  
				echo "</tr>";
			}
			echo "</table>";
			
		echo "<hr>";
		
//--
	}//end detail
	//echo "<hr size='2' style='outline-style:double' />";
	//echo "<hr>";
}?>
<script>
//alert('cetak');window.print();
</script>
</body>
</html>
