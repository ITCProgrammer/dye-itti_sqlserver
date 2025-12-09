<?php
ini_set("error_reporting", 1);
session_start();
include"./../koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="180">
		<title>Status Celup Dyeing ITTI</title>
<style>
td{
		padding: 1px 0px;
}	
			.blink_me {
  animation: blinker 1s linear infinite;
}
@keyframes blinker {
  50% { opacity: 0; }
}
	body{
		font-family: Calibri, "sans-serif", "Courier New";  /* "Calibri Light","serif" */
		font-style: normal;
	}
</style>

		<link rel="stylesheet" href="./../bower_components/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="./../bower_components/font-awesome/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="./../bower_components/Ionicons/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="./../dist/css/AdminLTE.min.css">
		<!-- toast CSS -->
		<link href="./../bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
		<!-- DataTables -->
		<link rel="stylesheet" href="./../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
		<!-- bootstrap datepicker -->
		<link rel="stylesheet" href="./../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
		<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
		<link rel="stylesheet" href="./../dist/css/skins/skin-purple.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

		<!-- Google Font -->
		<!--
  <link rel="stylesheet"
        href="./../dist/css/font/font.css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	-->

		<link rel="icon" type="image/png" href="./../dist/img/index.ico">
		<style type="text/css">
			.teks-berjalan {
				background-color: #03165E;
				color: #F4F0F0;
				font-family: monospace;
				font-size: 24px;
				font-style: italic;
			}

			.border-dashed {
				border: 4px dashed #083255;
			}

			.bulat {
				border-radius: 50%;
				/*box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);*/
			}

		</style>
	</head>

	<body>
	<?php
		function tampil($mc,$shift){
			$qry=mysqli_query($con,"SELECT a.no_mesin,b.target,b.lama,b.jenis_kain,b.kategori_warna,b.proses,b.g_shift,b.operator FROM tbl_mesin a 
LEFT JOIN (
SELECT TIME_FORMAT(timediff(now(),b.tgl_buat),'%H:%i') as lama,a.no_mesin,a.jenis_kain,a.target,a.kategori_warna,a.proses,b.g_shift,b.operator FROM tbl_schedule a
LEFT JOIN tbl_montemp b ON a.nokk=b.nokk
WHERE b.status='sedang jalan' AND b.g_shift='$shift' ORDER BY a.no_urut ASC
) b ON a.no_mesin=b.no_mesin
WHERE a.no_mesin='$mc'");
			while ($row=mysqli_fetch_array($qry)){
			$hasil[]=$row;
			}
			return $hasil;
		}		
	?>	
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Status Mesin Dyeing ITTI</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<a href="../index1.php?p=Status-Mesin" class="btn btn-xs" data-toggle="tooltip" data-html="true" data-placement="bottom" title="MiniScreen"><i class="fa fa-expand"></i></a>
						</div>
					</div>
				  <div class="box-body table-responsive">
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="12000">                
                <div class="carousel-inner">
        <div class="item active">
		 <table id="tblr1" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No MC</div></th>
              <th><div align="center">Shift</div></th>
              <th><div align="center">Operator</div></th>
              <th><div align="center">Jenis Kain</div></th>
              <th><div align="center">Proses</div></th>
              <th><div align="center">Kategori Warna</div></th>
			  <th><div align="center">Target</div></th>	
              <th><div align="center">Lama Proses</div></th>
              <th><div align="center">K.R</div></th>
              <th><div align="center">Point</div></th>
            </tr>
          </thead>
          <tbody>
            <?php
			$data1=mysqli_query($con,"SELECT * FROM tbl_mesin ORDER BY no_mesin ASC Limit 0,25");
			$col=0;
	  		while($rowd1=mysqli_fetch_array($data1)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
				$mesin=$rowd1['no_mesin'];
				$op=tampil($mesin,"A");				
				foreach($op as $dt)
				$qry1=mysqli_query($con,"SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out 
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' 
	AND b.g_shift = 'A' 
	AND a.no_mesin = '$mesin' 
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) 
	AND DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	b.tgl_buat DESC LIMIT 1");
				$row1=mysqli_fetch_array($qry1);
				
		 ?>
            <tr>
              <td align="center"><?php echo $rowd1['no_mesin'];?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['g_shift'];}else{echo $row1['g_shift']; }?></td>
              <td align="center" bgcolor="<?php if($row1['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row1['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['operator'];}else{echo $row1['operator']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['jenis_kain'];}else{echo $row1['jenis_kain']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['proses'];}else{echo $row1['proses']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['kategori_warna'];}else{echo $row1['kategori_warna']; }?></td>
			  <td align="center"><?php if($dt['g_shift']!=""){echo $dt['target'];}else{echo $row1['target']; }?></td>	
              <td align="center" bgcolor="<?php if($row1['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row1['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['lama'];}else{echo $row1['lama']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row1['k_resep'];}?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row1['point'];}?></td>
              
            </tr>
            <?php	 $no++;  } ?>
          </tbody>
        </table>
		</div>
        <div class="item">					  
        <table id="tblr2" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No MC</div></th>
              <th><div align="center">Shift</div></th>
              <th><div align="center">Operator</div></th>
              <th><div align="center">Jenis Kain</div></th>
              <th><div align="center">Proses</div></th>
              <th><div align="center">Kategori Warna</div></th>
			  <th><div align="center">Target</div></th>	
              <th><div align="center">Lama Proses</div></th>
              <th><div align="center">K.R</div></th>
              <th><div align="center">Point</div></th>	
            </tr>
          </thead>
          <tbody>
         <?php
		  $data2=mysqli_query($con,"SELECT * FROM tbl_mesin ORDER BY no_mesin ASC LIMIT 25,25");					
		  while($rowd2=mysqli_fetch_array($data2)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
			    $mesin=$rowd2['no_mesin'];
				$op=tampil($mesin,"A");				
				foreach($op as $dt)
			$qry2=mysqli_query($con,"SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out  
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' 
	AND b.g_shift = 'A' 
	AND a.no_mesin = '$mesin' 
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) 
	AND DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	b.tgl_buat DESC LIMIT 1");
				$row2=mysqli_fetch_array($qry2);		
		 ?>
            <tr>
              <td align="center"><?php echo $rowd2['no_mesin'];?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['g_shift'];}else{echo $row2['g_shift']; }?></td>
              <td align="center" bgcolor="<?php if($row2['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row2['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['operator'];}else{echo $row2['operator']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['jenis_kain'];}else{echo $row2['jenis_kain']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['proses'];}else{echo $row2['proses']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['kategori_warna'];}else{echo $row2['kategori_warna']; }?></td>
			  <td align="center"><?php if($dt['g_shift']!=""){echo $dt['target'];}else{echo $row2['target']; }?></td>	
              <td align="center" bgcolor="<?php if($row2['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row2['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['lama'];}else{echo $row2['lama']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row2['k_resep'];}?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row2['point'];}?></td>	
            </tr>
            <?php	$no++;  } ?>
          </tbody>
        </table>  
		</div>
		<div class="item">					  
        <table id="tblr3" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No MC</div></th>
              <th><div align="center">Shift</div></th>
              <th><div align="center">Operator</div></th>
              <th><div align="center">Jenis Kain</div></th>
              <th><div align="center">Proses</div></th>
              <th><div align="center">Kategori Warna</div></th>
			  <th><div align="center">Target</div></th>	
              <th><div align="center">Lama Proses</div></th>
              <th><div align="center">K.R</div></th>
              <th><div align="center">Point</div></th>
            </tr>
          </thead>
          <tbody>
         <?php
		  $data3=mysqli_query($con,"SELECT * FROM tbl_mesin ORDER BY no_mesin ASC LIMIT 50,25");					
		  while($rowd3=mysqli_fetch_array($data3)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
			  	$mesin=$rowd3['no_mesin'];
				$op=tampil($mesin,"A");				
				foreach($op as $dt)
			$qry3=mysqli_query($con,"SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out  
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' 
	AND b.g_shift = 'A' 
	AND a.no_mesin = '$mesin' 
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) 
	AND DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	b.tgl_buat DESC LIMIT 1");
				$row3=mysqli_fetch_array($qry3);			
		 ?>
            <tr>
              <td align="center"><?php echo $rowd3['no_mesin'];?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['g_shift'];}else{echo $row3['g_shift']; }?></td>
              <td align="center" bgcolor="<?php if($row3['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row3['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['operator'];}else{echo $row3['operator']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['jenis_kain'];}else{echo $row3['jenis_kain']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['proses'];}else{echo $row3['proses']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['kategori_warna'];}else{echo $row3['kategori_warna']; }?></td>
			  <td align="center"><?php if($dt['g_shift']!=""){echo $dt['target'];}else{echo $row3['target']; }?></td>	
              <td align="center" bgcolor="<?php if($row3['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row3['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['lama'];}else{echo $row3['lama']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row3['k_resep'];}?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row3['point'];}?></td>	
            </tr>
            <?php	$no++;  } ?>
          </tbody>
        </table>  
		</div>			
        <div class="item">
		<table id="tblr1" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No MC</div></th>
              <th><div align="center">Shift</div></th>
              <th><div align="center">Operator</div></th>
              <th><div align="center">Jenis Kain</div></th>
              <th><div align="center">Proses</div></th>
              <th><div align="center">Kategori Warna</div></th>
			  <th><div align="center">Target</div></th>	
              <th><div align="center">Lama Proses</div></th>
              <th><div align="center">K.R</div></th>
              <th><div align="center">Point</div></th>
            </tr>
          </thead>
          <tbody>
            <?php
  $data4=mysqli_query($con,"SELECT * FROM tbl_mesin ORDER BY no_mesin ASC LIMIT 0,25");
  while($rowd4=mysqli_fetch_array($data4)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  			$mesin=$rowd4['no_mesin'];
				$op=tampil($mesin,"B");				
				foreach($op as $dt)
			$qry4=mysqli_query($con,"SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out 
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' 
	AND b.g_shift = 'B' 
	AND a.no_mesin = '$mesin' 
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) 
	AND DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	b.tgl_buat DESC LIMIT 1");
				$row4=mysqli_fetch_array($qry4);
		 ?>
            <tr>
              <td align="center"><?php echo $rowd4['no_mesin'];?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['g_shift'];}else{echo $row4['g_shift']; }?></td>
              <td align="center" bgcolor="<?php if($row4['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row4['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['operator'];}else{echo $row4['operator']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['jenis_kain'];}else{echo $row4['jenis_kain']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['proses'];}else{echo $row4['proses']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['kategori_warna'];}else{echo $row4['kategori_warna']; }?></td>
			  <td align="center"><?php if($dt['g_shift']!=""){echo $dt['target'];}else{echo $row4['target']; }?></td>	
              <td align="center" bgcolor="<?php if($row4['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row4['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['lama'];}else{echo $row4['lama']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row4['k_resep'];}?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row4['point'];}?></td>             
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>  
        </div>
		<div class="item">
		<table id="tblr2" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No MC</div></th>
              <th><div align="center">Shift</div></th>
              <th><div align="center">Operator</div></th>
              <th><div align="center">Jenis Kain</div></th>
              <th><div align="center">Proses</div></th>
              <th><div align="center">Kategori Warna</div></th>
			  <th><div align="center">Target</div></th>	
              <th><div align="center">Lama Proses</div></th>
              <th><div align="center">K.R</div></th>
              <th><div align="center">Point</div></th>
            </tr>
          </thead>
          <tbody>
            <?php
  $data5=mysqli_query($con,"SELECT * FROM tbl_mesin ORDER BY no_mesin ASC LIMIT 25,25");
  while($rowd5=mysqli_fetch_array($data5)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  			$mesin=$rowd5['no_mesin'];
				$op=tampil($mesin,"B");				
				foreach($op as $dt)
			$qry5=mysqli_query($con,"SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out 
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' 
	AND b.g_shift = 'B' 
	AND a.no_mesin = '$mesin' 
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) 
	AND DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	b.tgl_buat DESC LIMIT 1");
				$row5=mysqli_fetch_array($qry5);
		 ?>
            <tr>
              <td align="center"><?php echo $rowd5['no_mesin'];?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['g_shift'];}else{echo $row5['g_shift']; }?></td>
              <td align="center" bgcolor="<?php if($row5['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row5['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['operator'];}else{echo $row5['operator']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['jenis_kain'];}else{echo $row5['jenis_kain']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['proses'];}else{echo $row5['proses']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['kategori_warna'];}else{echo $row5['kategori_warna']; }?></td>
			  <td align="center"><?php if($dt['g_shift']!=""){echo $dt['target'];}else{echo $row5['target']; }?></td>	
              <td align="center" bgcolor="<?php if($row5['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row5['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['lama'];}else{echo $row5['lama']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row5['k_resep'];}?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row5['point'];}?></td> 
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>  
        </div>
		<div class="item">
		<table id="tblr3" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No MC</div></th>
              <th><div align="center">Shift</div></th>
              <th><div align="center">Operator</div></th>
              <th><div align="center">Jenis Kain</div></th>
              <th><div align="center">Proses</div></th>
              <th><div align="center">Kategori Warna</div></th>
			  <th><div align="center">Target</div></th>	
              <th><div align="center">Lama Proses</div></th>
              <th><div align="center">K.R</div></th>
              <th><div align="center">Point</div></th>	
            </tr>
          </thead>
          <tbody>
            <?php
  $data6=mysqli_query($con,"SELECT * FROM tbl_mesin ORDER BY no_mesin ASC LIMIT 50,25");
  while($rowd6=mysqli_fetch_array($data6)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  			$mesin=$rowd6['no_mesin'];
				$op=tampil($mesin,"B");				
				foreach($op as $dt)
			$qry6=mysqli_query($con,"SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out 
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' 
	AND b.g_shift = 'B' 
	AND a.no_mesin = '$mesin' 
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) 
	AND DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	b.tgl_buat DESC LIMIT 1");
				$row6=mysqli_fetch_array($qry6);
		 ?>
            <tr>
              <td align="center"><?php echo $rowd6['no_mesin'];?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['g_shift'];}else{echo $row6['g_shift']; }?></td>
              <td align="center" bgcolor="<?php if($row6['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row6['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['operator'];}else{echo $row6['operator']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['jenis_kain'];}else{echo $row6['jenis_kain']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['proses'];}else{echo $row6['proses']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['kategori_warna'];}else{echo $row6['kategori_warna']; }?></td>
			  <td align="center"><?php if($dt['g_shift']!=""){echo $dt['target'];}else{echo $row6['target']; }?></td>	
              <td align="center" bgcolor="<?php if($row6['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row6['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['lama'];}else{echo $row6['lama']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row6['k_resep'];}?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row6['point'];}?></td>
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>  
        </div>			
		<div class="item">
		<table id="tblr1" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No MC</div></th>
              <th><div align="center">Shift</div></th>
              <th><div align="center">Operator</div></th>
              <th><div align="center">Jenis Kain</div></th>
              <th><div align="center">Proses</div></th>
              <th><div align="center">Kategori Warna</div></th>
			  <th><div align="center">Target</div></th>	
              <th><div align="center">Lama Proses</div></th>
              <th><div align="center">K.R</div></th>
              <th><div align="center">Point</div></th>
            </tr>
          </thead>
          <tbody>
            <?php
  $data7=mysqli_query($con,"SELECT * FROM tbl_mesin ORDER BY no_mesin ASC LIMIT 0,25");
  while($rowd7=mysqli_fetch_array($data7)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  			$mesin=$rowd7['no_mesin'];
				$op=tampil($mesin,"C");				
				foreach($op as $dt)
			$qry7=mysqli_query($con,"SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out 
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' 
	AND b.g_shift = 'C' 
	AND a.no_mesin = '$mesin' 
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) 
	AND DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	b.tgl_buat DESC LIMIT 1");
				$row7=mysqli_fetch_array($qry7);
		 ?>
            <tr>
              <td align="center"><?php echo $rowd7['no_mesin'];?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['g_shift'];}else{echo $row7['g_shift']; }?></td>
              <td align="center" bgcolor="<?php if($row7['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row7['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['operator'];}else{echo $row7['operator']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['jenis_kain'];}else{echo $row7['jenis_kain']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['proses'];}else{echo $row7['proses']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['kategori_warna'];}else{echo $row7['kategori_warna']; }?></td>
			  <td align="center"><?php if($dt['g_shift']!=""){echo $dt['target'];}else{echo $row7['target']; }?></td>	
              <td align="center" bgcolor="<?php if($row7['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row7['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['lama'];}else{echo $row7['lama']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row7['k_resep'];}?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row7['point'];}?></td>
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>  
        </div>
		<div class="item">
		<table id="tblr2" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No MC</div></th>
              <th><div align="center">Shift</div></th>
              <th><div align="center">Operator</div></th>
              <th><div align="center">Jenis Kain</div></th>
              <th><div align="center">Proses</div></th>
              <th><div align="center">Kategori Warna</div></th>
			  <th><div align="center">Target</div></th>	
              <th><div align="center">Lama Proses</div></th>
              <th><div align="center">K.R</div></th>
              <th><div align="center">Point</div></th>	
            </tr>
          </thead>
          <tbody>
            <?php
  $data8=mysqli_query($con,"SELECT * FROM tbl_mesin ORDER BY no_mesin ASC LIMIT 25,25");
  while($rowd8=mysqli_fetch_array($data8)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  			$mesin=$rowd8['no_mesin'];
				$op=tampil($mesin,"C");				
				foreach($op as $dt)
			$qry8=mysqli_query($con,"SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out 
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' 
	AND b.g_shift = 'C' 
	AND a.no_mesin = '$mesin' 
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) 
	AND DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	b.tgl_buat DESC LIMIT 1");
				$row8=mysqli_fetch_array($qry8);
		 ?>
            <tr>
              <td align="center"><?php echo $rowd8['no_mesin'];?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['g_shift'];}else{echo $row8['g_shift']; }?></td>
              <td align="center" bgcolor="<?php if($row8['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row8['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['operator'];}else{echo $row8['operator']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['jenis_kain'];}else{echo $row8['jenis_kain']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['proses'];}else{echo $row8['proses']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['kategori_warna'];}else{echo $row8['kategori_warna']; }?></td>
			  <td align="center"><?php if($dt['g_shift']!=""){echo $dt['target'];}else{echo $row8['target']; }?></td>	
              <td align="center" bgcolor="<?php if($row8['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row8['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['lama'];}else{echo $row8['lama']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row8['k_resep'];}?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row8['point'];}?></td>
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>  
        </div>
		<div class="item">
		<table id="tblr3" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No MC</div></th>
              <th><div align="center">Shift</div></th>
              <th><div align="center">Operator</div></th>
              <th><div align="center">Jenis Kain</div></th>
              <th><div align="center">Proses</div></th>
              <th><div align="center">Kategori Warna</div></th>
			  <th><div align="center">Target</div></th>	
              <th><div align="center">Lama Proses</div></th>
              <th><div align="center">K.R</div></th>
              <th><div align="center">Point</div></th>	
            </tr>
          </thead>
          <tbody>
            <?php
  $data9=mysqli_query($con,"SELECT * FROM tbl_mesin ORDER BY no_mesin ASC LIMIT 50,25");
  while($rowd9=mysqli_fetch_array($data9)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  			$mesin=$rowd9['no_mesin'];
				$op=tampil($mesin,"C");				
				foreach($op as $dt)
			$qry9=mysqli_query($con,"SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out  
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' 
	AND b.g_shift = 'C' 
	AND a.no_mesin = '$mesin' 
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) 
	AND DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	b.tgl_buat DESC LIMIT 1");
				$row9=mysqli_fetch_array($qry9);
		 ?>
            <tr>
              <td align="center"><?php echo $rowd9['no_mesin'];?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['g_shift'];}else{echo $row9['g_shift']; }?></td>
              <td align="center" bgcolor="<?php if($row9['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row9['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['operator'];}else{echo $row9['operator']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['jenis_kain'];}else{echo $row9['jenis_kain']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['proses'];}else{echo $row9['proses']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){echo $dt['kategori_warna'];}else{echo $row9['kategori_warna']; }?></td>
			  <td align="center"><?php if($dt['g_shift']!=""){echo $dt['target'];}else{echo $row9['target']; }?></td>	
              <td align="center" bgcolor="<?php if($row9['ket']=="Over" and $dt['g_shift']==""){ echo "#FD5B5B";}else if($row9['ket']=="OK" and $dt['g_shift']==""){echo "#14EF78";} ?>"><?php if($dt['g_shift']!=""){echo $dt['lama'];}else{echo $row9['lama']; }?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row9['k_resep'];}?></td>
              <td align="center"><?php if($dt['g_shift']!=""){}else{echo $row9['point'];}?></td>
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>  
        </div>			
                </div>                
              </div>
				  </div>

				</div>

			</div>
		</div>	
	</body>
	<!-- Tooltips -->
	<!-- jQuery 3 -->
	<script src="./../bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="./../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- AdminLTE App -->
	<script src="./../dist/js/adminlte.min.js"></script>

	<!-- DataTables -->
	<script src="./../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="./../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<!-- bootstrap datepicker -->
	<script src="./../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
	<script src="./../bower_components/toast-master/js/jquery.toast.js"></script>
	<!-- Tooltips -->
	<script src="./../../dist/js/tooltips.js"></script>
	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	</script>
	<!-- Javascript untuk popup modal Edit-->
	<script type="text/javascript">
		$(document).on('click', '.detail_status', function(e) {
			var m = $(this).attr("id");
			$.ajax({
				url: "./cek-status-mesin.php",
				type: "GET",
				data: {
					id: m,
				},
				success: function(ajaxData) {
					$("#CekDetailStatus").html(ajaxData);
					$("#CekDetailStatus").modal('show', {
						backdrop: 'true'
					});
				}
			});
		});

		//            tabel lookup KO status terima
		$(function() {
			$("#lookup").dataTable();
		});

	</script>
	<script>
		$(document).ready(function() {
			"use strict";
			// toat popup js
			$.toast({
				heading: 'Selamat Datang',
				text: 'Dyeing Indo Taichen',
				position: 'bottom-right',
				loaderBg: '#ff6849',
				icon: 'success',
				hideAfter: 3500,
				stack: 6
			})


		});
		$(".tst1").on("click", function() {
			var msg = $('#message').val();
			var title = $('#title').val() || '';
			$.toast({
				heading: 'Info',
				text: msg,
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'info',
				hideAfter: 3000,
				stack: 6
			});

		});
		$('#tblr1').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr2').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr3').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr4').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr5').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr6').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr7').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr8').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr9').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr10').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr11').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
        $('#tblr12').DataTable({'paging': false,'ordering': false,
        'info': false,'searching': false});
	</script>

</html>
