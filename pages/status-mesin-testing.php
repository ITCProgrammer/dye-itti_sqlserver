<?php
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="180">
		<title>Status Mesin</title>
		<style>
			td {
				padding: 1px 0px;
			}
			p {
   				line-height: 4px;
				font-size: 10px;
			}
		</style>
		<style type="text/css">
			.teks-berjalan {
				background-color: #03165E;
				color: #F4F0F0;
				font-family: monospace;
				font-size: 24px;
				font-style: italic;
			}

		</style>
	</head>

	<body>
		
		<div class="row">
			<div class="col-xs-12">
				<div class="box table-responsive">
					<div class="box-header with-border">
						<h3 class="box-title">Status Mesin Dyeing ITTI</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<a href="pages/status-mesin-full.php" class="btn btn-xs" data-toggle="tooltip" data-html="true" data-placement="bottom" title="FullScreen"><i class="fa fa-expand"></i></a>
						</div>
					</div>
					<div class="box-body">
<?php
function NoMesin($mc)
{
	include"koneksi.php";
	/*,IF(DATEDIFF(now(),a.tgl_delivery) > 0,'Urgent',
IF(DATEDIFF(now(),a.tgl_delivery) > -4,'Potensi Delay','')) as `sts`*/
	$qMC=mysqli_query($con,"SELECT a.ket_status,a.tgl_delivery, now() as tgl_skrg FROM tbl_schedule a 
LEFT JOIN tbl_montemp b ON a.id=b.id_schedule
WHERE a.no_mesin='$mc' and (b.`status`='sedang jalan' or a.`status`='antri mesin') ORDER BY a.no_urut ASC");
	$dMC=mysqli_fetch_array($qMC);	
	
		$awalDY  = strtotime($dMC['tgl_skrg']);
		$akhirDY = strtotime($dMC['tgl_delivery']);
		$diffDY  = ($akhirDY - $awalDY);
		$tjamDY  = round($diffDY/(60 * 60),2);
		$hariDY  = round($tjamDY/24);
	
	$qLama=mysqli_query($con,"SELECT b.tgl_target, now() as tgl_skrg FROM tbl_schedule a
LEFT JOIN tbl_montemp b ON a.id=b.id_schedule
WHERE a.no_mesin='$mc' AND b.status='sedang jalan' ORDER BY a.no_urut ASC");
		$dLama=mysqli_fetch_array($qLama);
		$awalPR  = strtotime($dLama['tgl_skrg']);
		$akhirPR = strtotime($dLama['tgl_target']);
		$diffPR  = ($akhirPR - $awalPR);
		$tjamPR  = round($diffPR/(60 * 60),2);
		$hariPR  = round($tjamPR/24,2);
	
	
		if($dMC['ket_status']=="Tolak Basah"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="btn-warning blink_me1";
			}else if($hariDY > -4){
				$warnaMc="btn-warning border-dashed";							
			}else if($hariDY > 0){ 
				$warnaMc="btn-warning blink_me";
			}else{ 
				$warnaMc="btn-warning";}
		}else if($dMC['ket_status']=="Mini Bulk"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="btn-primary blink_me1";
			}else if($hariDY > -4){
				$warnaMc="btn-primary border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="btn-primary blink_me";
			}else{ 
				$warnaMc="btn-primary";}			
		}else if($dMC['ket_status']=="MC Stop"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-black blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-black border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-black blink_me";
			}else{ 
				$warnaMc="bg-black";}
		}else if($dMC['ket_status']=="MC Rusak"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-abu blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-abu border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-abu blink_me";
			}else{ 
				$warnaMc="bg-abu";}
		}else if($dMC['ket_status']=="MC Dibongkar"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-aqua blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-aqua border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-aqua blink_me";
			}else{ 
				$warnaMc="bg-aqua";}
		}else if($dMC['ket_status']=="Test Proses"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-navy blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-navy border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-navy blink_me";
			}else{ 
				$warnaMc="bg-navy";}
		}else if($dMC['ket_status']=="Cuci Misty"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-teal blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-teal border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-teal blink_me";
			}else{ 
				$warnaMc="bg-teal";}
		}else if($dMC['ket_status']=="Kain Basah"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-maroon blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-maroon border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-maroon blink_me";
			}else{ 
				$warnaMc="bg-maroon";}
		}else if($dMC['ket_status']=="Relaxing-Preset" or $dMC['ket_status']=="Scouring-Preset" or $dMC['ket_status']=="Continuous"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-purple blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-purple border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-purple blink_me";
			}else{ 
				$warnaMc="bg-purple";}
		}else if($dMC['ket_status']=="Greige"){	
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="btn-success blink_me1";
			}else if($hariDY > -4){
				$warnaMc="btn-success border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="btn-success blink_me";
			}else{ 
				$warnaMc="btn-success";}
		}else if($dMC['ket_status']=="Perbaikan"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="btn-danger blink_me1";	
			}else if($hariDY > -4){
				$warnaMc="btn-danger border-dashed";
			}else if($hariDY > 0){ 
				$warnaMc="btn-danger blink_me";
			}else{ 
				$warnaMc="btn-danger";}
		}else if($dMC['ket_status']=="Gagal Proses"){	
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-kuning blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-kuning border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-kuning blink_me";
			}else{ 
				$warnaMc="bg-kuning";}
		}else if($dMC['ket_status']=="Cuci YD"){	
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-hijau blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-hijau border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-hijau blink_me";
			}else{ 
				$warnaMc="bg-hijau";}
		}else if($dMC['ket_status']=="Development Sample"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-fuchsia blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-fuchsia border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-fuchsia blink_me";
			}else{ 
				$warnaMc="bg-fuchsia";}
		}else if($dMC['ket_status']=="Salesmen Sample" or $dMC['ket_status']=="First Lot"){
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-lime blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-lime border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-lime blink_me";
			}else{ 
				$warnaMc="bg-lime";}
		}else if($dMC['ket_status']=="Cuci Mesin"){	
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="bg-violet blink_me1";
			}else if($hariDY > -4){
				$warnaMc="bg-violet border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="bg-violet blink_me";
			}else{ 
				$warnaMc="bg-violet";}	
		}else if($dMC['ket_status']=="Greige Delay"){	
			if($hariPR<"1" and $hariPR!=""){ 
				$warnaMc="btn-default blink_me1";
			}else if($hariDY > -4){
				$warnaMc="'btn'-default border-dashed";				
			}else if($hariDY > 0){ 
				$warnaMc="btn-default blink_me";
			}else{ 
				$warnaMc="btn-default";}
		}else{
		 $warnaMc="";
		}

    return $warnaMc;
}
function Rajut($mc)
{
	include"koneksi.php";
	$qMC=mysqli_query($con,"SELECT a.langganan,a.no_order,a.warna,a.proses FROM tbl_schedule a 
	LEFT JOIN tbl_montemp b ON a.id=b.id_schedule
	WHERE a.no_mesin='$mc' and b.status='sedang jalan' ORDER BY a.no_urut ASC LIMIT 1");
	$dMC=mysqli_fetch_array($qMC);
    echo "<font size=+2><u>".$mc."</u></font> <br>".$dMC['no_order']."<br> ".$dMC['langganan']."<br>".$dMC['warna']."<br>".$dMC['proses'];	
}
		function Waktu($mc){
			include"koneksi.php";
			$qLama=mysqli_query($con,"SELECT TIME_FORMAT(timediff(b.tgl_target,now()),'%H:%i') as lama FROM tbl_schedule a
LEFT JOIN tbl_montemp b ON a.id=b.id_schedule
WHERE a.no_mesin='$mc' AND b.status='sedang jalan' AND (ISNULL(b.tgl_stop) or NOT ISNULL(b.tgl_mulai)) ORDER BY a.no_urut ASC LIMIT 1");
			$dLama=mysqli_fetch_array($qLama);
			if($dLama['lama']!=""){echo $dLama['lama'];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";}
		}

/* Total Status Mesin */
    $sqlStatus=mysqli_query($con,"SELECT no_mesin FROM tbl_mesin");
    while ($rM=mysqli_fetch_array($sqlStatus)) {
        $sts=NoMesin($rM['no_mesin']);
        if ($sts=="btn-primary" or
           $sts=="btn-primary border-dashed" or
		   $sts=="btn-primary blink_me1" or	
           $sts=="btn-primary blink_me") {
            $MB="1";
        } else {
            $MB="0";
        }
		if ($sts=="bg-purple" or
           $sts=="bg-purple border-dashed" or
		   $sts=="bg-purple blink_me1" or	
           $sts=="bg-purple blink_me") {
            $SPT="1";
        } else {
            $SPT="0";
        }
        if ($sts=="btn-warning" or
           $sts=="btn-warning border-dashed" or
		   $sts=="btn-warning blink_me1" or	
           $sts=="btn-warning blink_me") {
            $FL="1";
        } else {
            $FL="0";
        }
        if ($sts=="btn-danger" or
           $sts=="btn-danger border-dashed" or
		   $sts=="btn-danger blink_me1" or	
           $sts=="btn-danger blink_me") {
            $PBK="1";
        } else {
            $PBK="0";
        }
        if ($sts=="btn-success" or
           $sts=="btn-success border-dashed" or
		   $sts=="btn-success blink_me1" or	
           $sts=="btn-success blink_me") {
            $GRG="1";
        } else {
            $GRG="0";
        }
        if ($sts=="btn-default" or
		   $sts=="btn-default border-dashed" or
		   $sts=="btn-default blink_me1" or	
           $sts=="btn-default blink_me") {
            $GD="1";
        } else {
            $GD="0";
        }
        if ($sts=="bg-kuning" or
           $sts=="bg-kuning border-dashed" or
		   $sts=="bg-kuning blink_me1" or	
           $sts=="bg-kuning blink_me") {
            $GPS="1";
        } else {
            $GPS="0";
        }
		if ($sts=="bg-hijau" or
           $sts=="bg-hijau border-dashed" or
		   $sts=="bg-hijau blink_me1" or	
           $sts=="bg-hijau blink_me") {
            $CYD="1";
        } else {
            $CYD="0";
        }
        if ($sts=="bg-black" or
           $sts=="bg-black border-dashed" or
		   $sts=="bg-black blink_me1" or	
           $sts=="bg-black blink_me") {
            $MCS="1";
        } else {
            $MCS="0";
        }
        if ($sts=="bg-abu" or
           $sts=="bg-abu border-dashed" or
		   $sts=="bg-abu blink_me1" or	
           $sts=="bg-abu blink_me") {
            $MCR="1";
        } else {
            $MCR="0";
		}
		if ($sts=="bg-aqua" or
           $sts=="bg-aqua border-dashed" or
		   $sts=="bg-aqua blink_me1" or	
           $sts=="bg-aqua blink_me") {
            $MCB="1";
        } else {
            $MCB="0";
        }
		if ($sts=="bg-teal" or
           $sts=="bg-teal border-dashed" or
		   $sts=="bg-teal blink_me1" or	
           $sts=="bg-teal blink_me") {
            $CMY="1";
        } else {
            $CMY="0";
        }
		if ($sts=="bg-fuchsia" or
           $sts=="bg-fuchsia border-dashed" or
		   $sts=="bg-fuchsia blink_me1" or	
           $sts=="bg-fuchsia blink_me") {
            $DTS="1";
        } else {
            $DTS="0";
        }
		if ($sts=="bg-lime" or
           $sts=="bg-lime border-dashed" or
		   $sts=="bg-lime blink_me1" or	
           $sts=="bg-lime blink_me") {
            $SMS="1";
        } else {
            $SMS="0";
        }
		if ($sts=="bg-violet" or
           $sts=="bg-violet border-dashed" or
		   $sts=="bg-violet blink_me1" or	
           $sts=="bg-violet blink_me") {
            $CMS="1";
        } else {
            $CMS="0";
        }
        if ($sts=="bg-abu border-dashed" or
		   $sts=="bg-black border-dashed" or
		   $sts=="bg-aqua border-dashed" or
           $sts=="bg-kuning border-dashed" or
		   $sts=="bg-hijau border-dashed" or	
           $sts=="btn-success border-dashed" or
           $sts=="btn-danger border-dashed" or
           $sts=="btn-warning border-dashed" or
           $sts=="btn-primary border-dashed" or
		   $sts=="bg-teal border-dashed" or
		   $sts=="bg-purple border-dashed" or	
		   $sts=="bg-fuchsia border-dashed" or
		   $sts=="bg-lime border-dashed" or	
		   $sts=="bg-violet border-dashed") {
            $PTD="1";
        } else {
            $PTD="0";
        }
        if ($sts=="bg-abu blink_me" or
		   $sts=="bg-black blink_me" or
		   $sts=="bg-aqua blink_me" or
		   $sts=="bg-kuning blink_me" or
		   $sts=="bg-hijau blink_me" or	
           $sts=="btn-success blink_me" or
           $sts=="btn-danger blink_me" or
           $sts=="btn-warning blink_me" or
           $sts=="btn-primary blink_me" or
		   $sts=="bg-teal blink_me" or
		   $sts=="bg-fuchsia blink_me" or
		   $sts=="bg-lime blink_me" or	
		   $sts=="bg-purple blink_me" or
		   $sts=="bg-violet blink_me") {
            $URG="1";
        } else {
            $URG="0";
        }
		
        $totPTD=$totPTD+$PTD;
        $totURG=$totURG+$URG;
		$totGRG=$totGRG+$GRG;
		$totCYD=$totCYD+$CYD;
		$totGPS=$totGPS+$GPS;
		$totPBK=$totPBK+$PBK;
		$totFL=$totFL+$FL;
		$totMB=$totMB+$MB;
		$totGD=$totGD+$GD;
		$totSPT=$totSPT+$SPT;
		$totMCR=$totMCR+$MCR;
		$totMCS=$totMCS+$MCS;
		$totMCB=$totMCB+$MCB;
		$totCMY=$totCMY+$CMY;
		$totDTS=$totDTS+$DTS;
		$totSMS=$totSMS+$SMS;
		$totCMS=$totCMS+$CMS;
		
    }
    
						
?>


						<table width="100%" border="0">
							<tbody>
								<tr>
								  <td align="center" class="bg-purple">2400 KGs</td>
								  <td align="center" class="bg-black">1800 KGs</td>
								  <td colspan="2" align="center" class="bg-blue">1200 KGs</td>
								  <td colspan="2" align="center" class="bg-yellow">900 KGs</td>
								  <td colspan="2" align="center" class="bg-red">800 KGs</td>
								  <td colspan="2" align="center" class="bg-purple"> 750 KGs </td>
								  <td colspan="3" align="center" class="bg-black"> 600 KGs </td>
								  <td align="center" class="bg-black">&nbsp;</td>
								  <td colspan="2" align="center" class="bg-abu"> 400 KGs </td>
								  <td colspan="2" align="center" class="bg-fuchsia"> 300 KGs </td>
								  <td align="center" class="bg-aqua"> 200 KGs </td>
								  <td align="center" class="bg-yellow">150KGs</td>
								  <td colspan="2" align="center" class="bg-info"> 100 KGs </td>
								  <td colspan="3" align="center" class="bg-maroon">50 KGs</td>
								  <td align="center" class="bg-green">30 KGs</td>
								  <td colspan="2" align="center" class="bg-gray">20 KGs</td>
								  <td align="center" class="bg-lime">10 KGs</td>
								  <td align="center" class="bg-blue">5 KGs</td>
								  <td align="center" class="bg-teal">0 KGs</td>
						      </tr>
								<tr>
								  <td colspan="32" align="center" ></td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1401"); ?>" id="1401" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1401"); ?>">1401
								    <p><?php echo Waktu("1401"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("1411"); ?>" id="1411" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1411"); ?>">1411<p><?php echo Waktu("1411"); ?></p></span> </td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1402"); ?>" id="1402" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1402"); ?>">1402
								      <p><?php echo Waktu("1402"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1108"); ?>" id="1108" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1108"); ?>">1108
								      <p><?php echo Waktu("1108"); ?></p>
								    </span></td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("1114"); ?>" id="1114" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1114"); ?>">1114
									    <p><?php echo Waktu("1114"); ?></p></span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2625"); ?>" id="2625" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2625"); ?>">2625
									    <p><?php echo Waktu("2625"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2634"); ?>" id="2634" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2634"); ?>">2634
									    <p><?php echo Waktu("2634"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("1505"); ?>" id="1505" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1505"); ?>">1505
									    <p><?php echo Waktu("1505"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1410"); ?>" id="1410" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1410"); ?>">1410
									    <p><?php echo Waktu("1410"); ?></p>
									  </span></td>
									<td colspan="2" align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("2633"); ?>" id="2633" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2633"); ?>">2633
									    <p><?php echo Waktu("2633"); ?></p></span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td colspan="2" align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2230"); ?>" id="2230" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2230"); ?>">2230
									    <p><?php echo Waktu("2230"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1413"); ?>" id="1413" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1413"); ?>">1413
									    <p><?php echo Waktu("1413"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1419"); ?>" id="1419" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1419"); ?>">1419
									    <p><?php echo Waktu("1419"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("2228"); ?>" id="2228" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2228"); ?>">2228
									    <p><?php echo Waktu("2228"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1409"); ?>" id="1409" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1409"); ?>">1409
									    <p><?php echo Waktu("1409"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2665"); ?>" id="2665" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2665"); ?>">2665
									    <p><?php echo Waktu("2665"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("1452"); ?>" id="1452" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1452"); ?>">1452
									    <p><?php echo Waktu("1452"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("1457"); ?>" id="1457" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1457"); ?>">1457
									    <p><?php echo Waktu("1457"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("2660"); ?>" id="2660" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2660"); ?>">2660
									    <p><?php echo Waktu("2660"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("2664"); ?>" id="2664" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2664"); ?>">2664
									    <p><?php echo Waktu("2664"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("2626"); ?>" id="2626" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2626"); ?>">2626
									  <p><?php echo Waktu("2626"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("2042"); ?>" id="2042" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2042"); ?>">2042
									    <p><?php echo Waktu("2042"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("2641"); ?>" id="2641" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2641"); ?>">2641
									    <p><?php echo Waktu("2641"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2638"); ?>" id="2638" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2638"); ?>">2638
									    <p><?php echo Waktu("2638"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1468"); ?>" id="1468" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1468"); ?>">1468
									  <p><?php echo Waktu("1468"); ?></p>
									  </span></td>
									
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("WS11"); ?>" id="WS11" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("WS11"); ?>">WS11
									    <p><?php echo Waktu("WS11"); ?></p></span> </td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1406"); ?>" id="1406" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1406"); ?>">1406
								    <p><?php echo Waktu("1406"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1103"); ?>" id="1103" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1103"); ?>">1103
								    <p><?php echo Waktu("1103"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1420"); ?>" id="1420" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1420"); ?>">1420
								      <p><?php echo Waktu("1420"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("2348"); ?>" id="2348" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2348"); ?>">2348
								      <p><?php echo Waktu("33"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2627"); ?>" id="2627" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2627"); ?>">2627
									    <p><?php echo Waktu("2627"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2229"); ?>" id="2229" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2229"); ?>">2229
									    <p><?php echo Waktu("2229"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1117"); ?>" id="1117" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1117"); ?>">1117
									    <p><?php echo Waktu("1117"); ?></p>
									  </span></td>
									<td colspan="2" align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("2632"); ?>" id="2632" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2632"); ?>">2632
									    <p><?php echo Waktu("2632"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td colspan="2" align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("2231"); ?>" id="2231" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2231"); ?>">2231
									    <p><?php echo Waktu("2231"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1412"); ?>" id="1412" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1412"); ?>">1412
									    <p><?php echo Waktu("1412"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1449"); ?>" id="1449" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1449"); ?>">1449
									    <p><?php echo Waktu("1449"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1450"); ?>" id="1450" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1450"); ?>">1450
									    <p><?php echo Waktu("1450"); ?></p>
								    </span></td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2666"); ?>" id="2666" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2666"); ?>">2666
									    <p><?php echo Waktu("28"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("1453"); ?>" id="1453" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1453"); ?>">1453
									    <p><?php echo Waktu("1453"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("1456"); ?>" id="1456" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1456"); ?>">1456
									    <p><?php echo Waktu("1456"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("2661"); ?>" id="2661" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2661"); ?>">2661
									    <p><?php echo Waktu("2661"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1459"); ?>" id="1459" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1459"); ?>">1459
									    <p><?php echo Waktu("1459"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("2043"); ?>" id="2043" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2043"); ?>">2043
									    <p><?php echo Waktu("2043"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("2640"); ?>" id="2640" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2640"); ?>">2640
									    <p><?php echo Waktu("2640"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1469"); ?>" id="1469" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1469"); ?>">1469
									  <p><?php echo Waktu("1469"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("CB11"); ?>" id="CB11" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("CB11"); ?>">CB11
									    <p><?php echo Waktu("CB11"); ?></p></span> </td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1107"); ?>" id="1107" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1107"); ?>">1107
								    <p><?php echo Waktu("1107"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1104"); ?>" id="1104" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1104"); ?>">1104
								      <p><?php echo Waktu("1104"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1421"); ?>" id="1421" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1421"); ?>">1421
								      <p><?php echo Waktu("1421"); ?></p>
								    </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2637"); ?>" id="2637" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2637"); ?>">2637
									    <p><?php echo Waktu("2637"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2246"); ?>" id="2246" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2246"); ?>">2246
									    <p><?php echo Waktu("2246"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1116"); ?>" id="1116" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1116"); ?>">1116
									    <p><?php echo Waktu("1116"); ?></p>
									  </span></td>
									<td colspan="2" align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1451"); ?>" id="1451" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1451"); ?>">1451
									    <p><?php echo Waktu("1451"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td colspan="2" align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("1118"); ?>" id="1118" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1118"); ?>">1118
									    <p><?php echo Waktu("1118"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2667"); ?>" id="2667" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2667"); ?>">2667
									    <p><?php echo Waktu("2667"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("2622"); ?>" id="2622" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2622"); ?>">2622
									    <p><?php echo Waktu("2622"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("1455"); ?>" id="1455" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1455"); ?>">1455
									    <p><?php echo Waktu("1455"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("2662"); ?>" id="2662" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2662"); ?>">2662
									    <p><?php echo Waktu("2662"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("2624"); ?>" id="2624" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2624"); ?>">2624
									    <p><?php echo Waktu("2624"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("2044"); ?>" id="2044" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2044"); ?>">2044
							      <p><?php echo Waktu("2044"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("2639"); ?>" id="2639" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2639"); ?>">2639
									    <p><?php echo Waktu("2639"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
									<td bgcolor="#ECE7E7">&nbsp;</td>
									<td bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2636"); ?>" id="2636" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2636"); ?>">2636
									    <p><?php echo Waktu("2636"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-sm <?php echo NoMesin("2247"); ?>" id="2247" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2247"); ?>">2247
									    <p><?php echo Waktu("2247"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-sm <?php echo NoMesin("1115"); ?>" id="1115" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1115"); ?>">1115
									    <p><?php echo Waktu("1115"); ?></p>
									  </span></td>
									<td colspan="2" align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td colspan="2" align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("1458"); ?>" id="1458" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1458"); ?>">1458
									    <p><?php echo Waktu("1458"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-sm <?php echo NoMesin("2623"); ?>" id="2623" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2623"); ?>">2623
									    <p><?php echo Waktu("2623"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("1454"); ?>" id="1454" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1454"); ?>">1454
									    <p><?php echo Waktu("1454"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("2663"); ?>" id="2663" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2663"); ?>">2663
									    <p><?php echo Waktu("2663"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-sm <?php echo NoMesin("2635"); ?>" id="2635" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2635"); ?>">2635
									    <p><?php echo Waktu("2635"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"> <span class="detail_status btn btn-sm <?php echo NoMesin("2045"); ?>" id="2045" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2045"); ?>">2045
									    <p><?php echo Waktu("2045"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#ECE7E7">&nbsp;</td>
								  <td bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td colspan="2" align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td colspan="2" align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
									<td colspan="2">Greige <span class="label label-success">&nbsp;<?php echo $totGRG;?></span></td>
									<td colspan="2">Gagal Proses <span class="label bg-kuning">&nbsp;<?php echo $totGPS;?></span></td>
									<td colspan="3">Tolak Basah <span class="label label-warning">&nbsp;<?php echo $totFL;?></span></td>
									<td>&nbsp;</td>
									<td colspan="6">Mini Bulk <span class="label label-primary">&nbsp;<?php echo $totMB;?></span></td>
									<td colspan="4"><font size="-1">Development Sample</font> <span class="label bg-fuchsia"> &nbsp;<?php echo $totDTS;?></span></td>
									<td colspan="3">Urgent <span class="label   bg-abu blink_me">&nbsp;<?php echo $totURG;?></span></td>
									<td colspan="2">Greige Delay <span class="label label-default"> &nbsp;<?php echo $totGD;?></span></td>
									<td>&nbsp;</td>
									<td colspan="3">Mesin Dibongkar <span class="label bg-aqua">&nbsp;<?php echo $totMCB;?></span></td>
									<td colspan="4">Mesin Rusak <span class="label bg-abu">&nbsp;<?php echo $totMCR;?></span></td>
								</tr>
								<tr>
								  <td colspan="2">Cuci Y/D <span class="label bg-hijau">&nbsp;<?php echo $totCYD;?></span></td>
								  <td colspan="2">Perbaikan <span class="label label-danger">&nbsp;<?php echo $totPBK;?></span></td>
								  <td colspan="3">Cuci Misty <span class="label bg-teal">&nbsp;<?php echo $totCMY;?></span></td>
								  <td>&nbsp;</td>
								  <td colspan="6"><font size="-2">Cont/Scour/Relax-Preset</font> <span class="label btn-sm bg-purple">&nbsp;<?php echo $totSPT;?></span></td>
								  <td colspan="4"><font size="-2">Salesmen Sample-1st Lot</font> <span class="label bg-lime">&nbsp;<?php echo $totSMS;?></span></td>
									<td colspan="4">Potensi Delay <span class="label bg-abu border-dashed">&nbsp;<?php echo $totPTD;?></span></td>
									<td colspan="3">Cuci Mesin <span class="label bg-violet">&nbsp;<?php echo $totCMS;?></span></td>
									<td colspan="4">Mesin Stop <span class="label btn-sm bg-black">&nbsp;<?php echo $totMCS;?></span></td>
									<td colspan="3">&nbsp;</td>
									
								</tr>
								<tr>
									<td colspan="32" style="padding: 5px;">
										<marquee class="teks-berjalan" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
											<?php
$news=mysqli_query($con,"SELECT GROUP_CONCAT(news_line SEPARATOR ' :: ') as news_line FROM tbl_news_line WHERE gedung='LT 1' AND status='Tampil'");
$rNews=mysqli_fetch_array($news);
$totMesin='0';
?>
											<?php echo $rNews['news_line'];?>
										</marquee>
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
<div id="CekDetailStatus" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

	</body>
	<!-- Tooltips -->
	<script src="dist/js/tooltips.js"></script>
	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	</script>

</html>
