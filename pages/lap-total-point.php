<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Harian Produksi</title>

</head>
<body>
<?php
$Awal	= isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir	= isset($_POST['akhir']) ? $_POST['akhir'] : '';
$GShift	= isset($_POST['gshift']) ? $_POST['gshift'] : '';	
$Fs		= isset($_POST['fasilitas']) ? $_POST['fasilitas'] : '';
$jamA	= isset($_POST['jam_awal']) ? $_POST['jam_awal'] : '';
$jamAr	= isset($_POST['jam_akhir']) ? $_POST['jam_akhir'] : '';	
if(strlen($jamA)==5){
	$start_date = $Awal.' '.$jamA;
}else{ 
	$start_date = $Awal.' 0'.$jamA;
}	
if(strlen($jamAr)==5){
	$stop_date  = $Akhir.' '.$jamAr;
}else{ 
	$stop_date  = $Akhir.' 0'.$jamAr;
}	
//$stop_date  = date('Y-m-d', strtotime($Awal . ' +1 day')).' 07:00:00';	
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"> Filter Laporan Harian Total POINT</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1">
    <div class="box-body">
      <div class="form-group">
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Awal" value="<?php echo $Awal; ?>" autocomplete="off"/>
          </div>
        </div>
		<div class="col-sm-2">
				  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="jam_awal" placeholder="00:00" value="<?php echo $jamA;?>" autocomplete="off">
					 
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                   </div>
                  </div>
			<div>
  </div>
			</div>  
        <!-- /.input group -->
      </div>
	  	
      <div class="form-group">
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>"  autocomplete="off"/>
          </div>
        </div>
        <div class="col-sm-2">
				  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="jam_akhir" placeholder="00:00" value="<?php echo $jamAr;?>" autocomplete="off">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                   </div>
                  </div>
			</div>
      </div>
		
      <div class="form-group">
                	<div class="col-sm-3">
                	<select name="gshift" class="form-control pull-right"> 
                	<option value="ALL">ALL</option>
                	<option value="A" <?php if($GShift=="A"){ echo "SELECTED";}?>>A</option>
                	<option value="B" <?php if($GShift=="B"){ echo "SELECTED";}?>>B</option>
					<option value="C" <?php if($GShift=="C"){ echo "SELECTED";}?>>C</option>
                	</select>
                	</div>			 
              </div>
                
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <div class="col-sm-2">
        <button type="submit" class="btn btn-block btn-social btn-linkedin btn-sm" name="save" style="width: 60%">Search <i class="fa fa-search"></i></button>
      </div>
    </div>
    <!-- /.box-footer -->
  </form>
</div>
<div class="row">
			<div class="col-xs-12">
				<div class="box table-responsive">
					<div class="box-header with-border">
						<h3 class="box-title">Total Point Mesin Dyeing ITTI</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<a href="pages/status-mesin-full.php" class="btn btn-xs" data-toggle="tooltip" data-html="true" data-placement="bottom" title="FullScreen"><i class="fa fa-expand"></i></a>
						</div>
					</div>
					<div class="box-body">
<?php
function Point($mc,$GShift1,$start_date1,$stop_date1)
{
	include"koneksi.php";
	if($GShift1=="ALL"){$shft=" ";}else{$shft=" if(ISNULL(a.g_shift),c.g_shift,a.g_shift)='$GShift1' AND ";}
	$Where=" DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$start_date1' AND '$stop_date1' AND ";
	if($Awal!="" and $Akhir!=""){ $Where1=" ";}else{ $Where1=" WHERE a.id='' ";}
	$qMC=mysqli_query($con,"SELECT    
	sum(a.point) as point
FROM
	tbl_schedule b
	LEFT JOIN  tbl_montemp c ON c.id_schedule = b.id
	LEFT JOIN tbl_hasilcelup a ON a.id_montemp=c.id
WHERE
	$shft
	$Where
	b.no_mesin='$mc'
	GROUP BY b.no_mesin");
	$dMC=mysqli_fetch_array($qMC);
	if($dMC['point']>0){
	echo "<br><font size='+1' color=black>".$dMC['point']."</font>";
	}else{
	echo "<br><font size='+1' color=black>0</font>";	
	}
}							
?>


						<table width="100%" border="2">
							<tbody>
								<tr>
								  <td align="center" class="bg-black">1800 KGs</td>
								  <td colspan="2" align="center" class="bg-blue">1200 KGs</td>
								  <td colspan="2" align="center" class="bg-yellow">900 KGs</td>
								  <td colspan="2" align="center" class="bg-red">800 KGs</td>
								  <td colspan="2" align="center" class="bg-purple"> 750 KGs </td>
								  <td colspan="3" align="center" class="bg-black"> 600 KGs </td>
								  <td align="center" class="bg-kuning"> 500 KGs </td>
								  <td colspan="2" align="center" class="bg-abu"> 400 KGs </td>
								  <td colspan="2" align="center" class="bg-fuchsia"> 300 KGs </td>
								  <td colspan="2" align="center" class="bg-aqua"> 200 KGs </td>
								  <td colspan="2" align="center" class="bg-yellow">150KGs</td>
								  <td colspan="2" align="center" class="bg-info"> 100 KGs </td>
								  <td colspan="2" align="center" class="bg-maroon"> 50 KGs </td>
								  <td colspan="2" align="center" class="bg-green"> 30 KGs </td>
								  <td colspan="2" align="center" class="bg-gray"> 20 KGs </td>
								  <td colspan="2" align="center" class="bg-lime"> 10 KGs </td>
								  <td align="center" class="bg-teal">0 KGs</td>
						      </tr>
								<tr>
								  <td colspan="32" align="center" ></td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="35" data-toggle="tooltip" data-html="true" title="">35
									  <b><?php echo Point("35",$GShift,$start_date,$stop_date); ?></b>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="01" data-toggle="tooltip" data-html="true" title="">01<b><?php echo Point("01",$GShift,$start_date,$stop_date); ?></b>
									</span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="17" data-toggle="tooltip" data-html="true" title="">17
									  <b><?php echo Point("17",$GShift,$start_date,$stop_date); ?></b>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="10" data-toggle="tooltip" data-html="true" title="">10<b><?php echo Point("10",$GShift,$start_date,$stop_date); ?></b>
									</span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="52" data-toggle="tooltip" data-html="true" title="">52<b><?php echo Point("52",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="63" data-toggle="tooltip" data-html="true" title="">63<b><?php echo Point("63",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="34" data-toggle="tooltip" data-html="true" title="">34<b><?php echo Point("34",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="09" data-toggle="tooltip" data-html="true" title="">09<b><?php echo Point("09",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="16" data-toggle="tooltip" data-html="true" title="">16<b><?php echo Point("16",$GShift,$start_date,$stop_date); ?></b>
									</span></td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="32" data-toggle="tooltip" data-html="true" title="">32
									  <b><?php echo Point("32",$GShift,$start_date,$stop_date); ?></b>
									  </span> </td>
									<td align="center" bgcolor="#ECE7E7"><span class="btn btn-sm btn-success" id="40" data-toggle="tooltip" data-html="true" title="">40
									  <b><?php echo Point("40",$GShift,$start_date,$stop_date); ?></b>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="66" data-toggle="tooltip" data-html="true" title="">66<b><?php echo Point("66",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="67" data-toggle="tooltip" data-html="true" title="">67<b><?php echo Point("67",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="03" data-toggle="tooltip" data-html="true" title="">03<b><?php echo Point("03",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="07" data-toggle="tooltip" data-html="true" title="">07<b><?php echo Point("07",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="64" data-toggle="tooltip" data-html="true" title="">64
									  <b><?php echo Point("64",$GShift,$start_date,$stop_date); ?></b>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"><span class="btn btn-sm btn-success" id="21" data-toggle="tooltip" data-html="true" title="">21
									  <b><?php echo Point("21",$GShift,$start_date,$stop_date); ?></b>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="btn btn-sm btn-success" id="31" data-toggle="tooltip" data-html="true" title="">31
									  <b><?php echo Point("31",$GShift,$start_date,$stop_date); ?></b>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="22" data-toggle="tooltip" data-html="true" title="">22<b><?php echo Point("22",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="49" data-toggle="tooltip" data-html="true" title="">49<b><?php echo Point("49",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="23" data-toggle="tooltip" data-html="true" title="">23<b><?php echo Point("23",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="27" data-toggle="tooltip" data-html="true" title="">27<b><?php echo Point("27",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="53" data-toggle="tooltip" data-html="true" title="">53<b><?php echo Point("53",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="43" data-toggle="tooltip" data-html="true" title="">43<b><?php echo Point("43",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="56" data-toggle="tooltip" data-html="true" title="">56<b><?php echo Point("56",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="59" data-toggle="tooltip" data-html="true" title="">59<b><?php echo Point("59",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm  btn-success" id="WS" data-toggle="tooltip" data-html="true" title="">WS<b><?php echo Point("WS",$GShift,$start_date,$stop_date); ?></b>
									</span> </td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="37" data-toggle="tooltip" data-html="true" title="">37
									  <b><?php echo Point("37",$GShift,$start_date,$stop_date); ?></b>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="02" data-toggle="tooltip" data-html="true" title="">02<b><?php echo Point("02",$GShift,$start_date,$stop_date); ?></b></span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="30" data-toggle="tooltip" data-html="true" title="">30<b><?php echo Point("30",$GShift,$start_date,$stop_date); ?></b>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="54" data-toggle="tooltip" data-html="true" title="">54<b><?php echo Point("54",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="65" data-toggle="tooltip" data-html="true" title="">65<b><?php echo Point("65",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="11" data-toggle="tooltip" data-html="true" title="">11<b><?php echo Point("11",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="18" data-toggle="tooltip" data-html="true" title="">18<b><?php echo Point("35",$GShift,$start_date,$stop_date); ?></b></span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"><span class="btn btn-sm btn-success" id="47" data-toggle="tooltip" data-html="true" title="">47
									    <b><?php echo Point("47",$GShift,$start_date,$stop_date); ?></b></span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="04" data-toggle="tooltip" data-html="true" title="">04<b><?php echo Point("04",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="08" data-toggle="tooltip" data-html="true" title="">08<b><?php echo Point("08",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="28" data-toggle="tooltip" data-html="true" title="">28<b><?php echo Point("28",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="50" data-toggle="tooltip" data-html="true" title="">50<b><?php echo Point("50",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="24" data-toggle="tooltip" data-html="true" title="">24<b><?php echo Point("24",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="51" data-toggle="tooltip" data-html="true" title="">51<b><?php echo Point("51",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="44" data-toggle="tooltip" data-html="true" title="">44<b><?php echo Point("44",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="57" data-toggle="tooltip" data-html="true" title="">57<b><?php echo Point("57",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="CB" data-toggle="tooltip" data-html="true" title="">CB<b><?php echo Point("CB",$GShift,$start_date,$stop_date); ?></b></span> </td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="05" data-toggle="tooltip" data-html="true" title="">05<b><?php echo Point("05",$GShift,$start_date,$stop_date); ?></b></span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="33" data-toggle="tooltip" data-html="true" title="">33<b><?php echo Point("33",$GShift,$start_date,$stop_date); ?></b> </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="60" data-toggle="tooltip" data-html="true" title="">60<b><?php echo Point("60",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="68" data-toggle="tooltip" data-html="true" title="">68<b><?php echo Point("68",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn  btn-sm btn-success" id="12" data-toggle="tooltip" data-html="true" title="">12<b><?php echo Point("12",$GShift,$start_date,$stop_date); ?></b></span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="19" data-toggle="tooltip" data-html="true" title="">19<b><?php echo Point("19",$GShift,$start_date,$stop_date); ?></b></span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"><span class="btn btn-sm btn-success" id="48" data-toggle="tooltip" data-html="true" title="">48<b><?php echo Point("48",$GShift,$start_date,$stop_date); ?></b></span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="06" data-toggle="tooltip" data-html="true" title="">06<b><?php echo Point("06",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7"><span class="btn btn-sm btn-success" id="36" data-toggle="tooltip" data-html="true" title="">36<b><?php echo Point("36",$GShift,$start_date,$stop_date); ?></b></span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="29" data-toggle="tooltip" data-html="true" title="">29<b><?php echo Point("29",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="25" data-toggle="tooltip" data-html="true" title="">25<b><?php echo Point("25",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="62" data-toggle="tooltip" data-html="true" title="">62<b><?php echo Point("62",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="45" data-toggle="tooltip" data-html="true" title="">45<b><?php echo Point("45",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="58" data-toggle="tooltip" data-html="true" title="">58<b><?php echo Point("58",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="14" data-toggle="tooltip" data-html="true" title="">14<b><?php echo Point("14",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td bgcolor="#E0DDDD">&nbsp;</td>
									<td bgcolor="#ECE7E7">&nbsp;</td>
									<td bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="61" data-toggle="tooltip" data-html="true" title="">61<b><?php echo Point("61",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="btn btn-sm btn-success" id="69" data-toggle="tooltip" data-html="true" title="">69<b><?php echo Point("69",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="15" data-toggle="tooltip" data-html="true" title="">15<b><?php echo Point("02",$GShift,$start_date,$stop_date); ?></b></span>  </td>
									<td align="center" bgcolor="#E0DDDD"><span class="btn btn-sm btn-success" id="20" data-toggle="tooltip" data-html="true" title="">20<b><?php echo Point("20",$GShift,$start_date,$stop_date); ?></b></span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="26" data-toggle="tooltip" data-html="true" title="">26<b><?php echo Point("26",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="btn btn-sm btn-success" id="46" data-toggle="tooltip" data-html="true" title="">46<b><?php echo Point("46",$GShift,$start_date,$stop_date); ?></b></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
									<td colspan="32" style="padding: 5px;">
										
									</td>
								</tr>								
								
								<!--
    <tr>
      <td colspan="26" style="padding: 5px;">&nbsp;</td>
    </tr> -->
							</tbody>
						</table>

				  </div>

				</div>

			</div>
		</div>	
	<!--
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Data POINT per Mesin</h3><br><br>
        <?php if($_POST['awal']!="") { ?><b>Periode: <?php echo $start_date." to ".$stop_date; ?></b> 
		<div class="btn-group pull-right hide">
		  <a href="pages/cetak/reports-harian-produksi.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-danger " target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi"><i class="fa fa-print"></i> </a>
		<a href="pages/cetak/reports-harian-produksi-excel.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-success " target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Excel"><i class="fa fa-file-excel-o"></i> </a>
		<a href="pages/cetak/rincian-cetak.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-warning " target="_blank" data-toggle="tooltip" data-html="true" title="Rincian Produksi"><i class="fa fa-print"></i> </a>	
		<a href="pages/cetak/rincian-excel.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-info " target="_blank" data-toggle="tooltip" data-html="true" title="Rincian Produksi Excel"><i class="fa fa-file-excel-o" ></i> </a>
		<a href="pages/cetak/schedule-excel.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn bg-maroon " target="_blank" data-toggle="tooltip" data-html="true" title="Schedule Produksi Excel"><i class="fa fa-file-excel-o" ></i> </a>			
		</div>  
		<?php } ?>
      
	  </div>
      <div class="box-body">
   

<table id="example1" class="table table-bordered table-hover" width="100%">
<thead class="btn-danger">
   <tr>
     <th width="38"><div align="center">Mesin</div></th>
     <th width="224"><div align="center">Point</div></th>
      </tr>
</thead>
<tbody>
  <?php   	
  $c=0;
  $no=0;
	if($GShift=="ALL"){$shft=" ";}else{$shft=" if(ISNULL(a.g_shift),c.g_shift,a.g_shift)='$GShift' AND ";}
	$Where=" DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$start_date' AND '$stop_date' ";
	if($Awal!="" and $Akhir!=""){ $Where1=" ";}else{ $Where1=" WHERE a.id='' ";}
  $sql=mysqli_query($con,"
  SELECT x.*,a.no_mesin as mc FROM tbl_mesin a
  LEFT JOIN
  (SELECT
    b.nokk,
	b.buyer,
	b.no_order,
	b.jenis_kain,
	b.lot,
	b.no_mesin,
	b.warna,
	b.proses,
	if(ISNULL(a.g_shift),c.g_shift,a.g_shift) as shft,
	c.operator,	if(c.status='selesai',if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))),TIME_FORMAT(timediff(now(),c.tgl_buat),'%H:%i')) as lama,
	b.`status` as sts,
	a.`status` as stscelup,
	sum(a.point) as point,
	a.proses as proses_aktual,
	a.id as idclp
FROM
	tbl_schedule b
	LEFT JOIN  tbl_montemp c ON c.id_schedule = b.id
	LEFT JOIN tbl_hasilcelup a ON a.id_montemp=c.id
WHERE
	$shft
	$Where
	GROUP BY b.no_mesin) x ON a.no_mesin=x.no_mesin $Where1 ORDER BY a.no_mesin ");	
  while($rowd=mysqli_fetch_array($sql)){
	 	$no++;
		$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  	$qCek=mysqli_query($con,"SELECT id as idb FROM tbl_potongcelup WHERE nokk='$rowd[nokk]' LIMIT 1");
	  	$rCEk=mysqli_fetch_array($qCek);
	?>
   <tr bgcolor="<?php echo $bgcolor; ?>" class="table table-bordered table-hover table-striped">
     <td align="center"><?php echo $rowd['mc'];?></td>
     <td align="center"><?php echo $rowd['point'];?></td>
     </tr>
   <?php }?>
   </tbody>
   
</table>
</form>

      </div>
    </div>
  </div>
</div>
-->
<div id="EditStsCelup" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>	
<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	</script>
</body>
</html>