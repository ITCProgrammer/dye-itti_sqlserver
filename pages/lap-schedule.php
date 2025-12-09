<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Schedule</title>

</head>
<body>
<?php
$Awal	= isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir	= isset($_POST['akhir']) ? $_POST['akhir'] : '';
$GShift	= isset($_POST['gshift']) ? $_POST['gshift'] : '';	
$Fs		= isset($_POST['fasilitas']) ? $_POST['fasilitas'] : '';
$start_date = $Awal.' 07:15:00'; 
$stop_date  = date('Y-m-d', strtotime($Awal . ' +1 day')).' 07:15:00';	
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"> Filter Laporan Schedule</h3>
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
        <!-- /.input group -->
      </div>
		
      <!--<div class="form-group">
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>" />
          </div>
        </div>        
      </div>-->
		
      <!--<div class="form-group">
                	<div class="col-sm-3">
                	<select name="gshift" class="form-control pull-right"> 
                	<option value="ALL">ALL</option>
                	<option value="A" <?php if($GShift=="A"){ echo "SELECTED";}?>>A</option>
                	<option value="B" <?php if($GShift=="B"){ echo "SELECTED";}?>>B</option>
					<option value="C" <?php if($GShift=="C"){ echo "SELECTED";}?>>C</option>
                	</select>
                	</div>
				 
              </div>-->                
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
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Data Schedule</h3><br><br>
        <?php if($_POST['awal']!="") { ?><b>Periode: <?php echo $start_date." to ".$stop_date; ?></b>
		<div class="btn-group pull-right">  
		<a href="pages/cetak/cetak_lap_schedule.php?&awal=<?php echo $Awal; ?>" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Cetak</a>
		<a href="#" data-toggle="modal" data-target="#PrintHalaman" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Pages</a>  
		</div>	
		<?php } ?>
      
	  </div>
      <div class="box-body">
   

<table id="example2" class="table table-bordered table-hover" width="100%">
<thead class="btn-success">
   <tr>
     <th width="38">Shift</th>
     <th width="38"><div align="center">Kap</div></th>
      <th width="38"><div align="center">Mesin</div></th>
      <th width="224"><div align="center">Urut</div></th>
      <th width="224"><div align="center">Pelanggan</div></th>
      <th width="314"><div align="center">Order</div></th>
      <th width="404"><div align="center">Jenis Kain</div></th>
      <th width="404"><div align="center">Warna</div></th>
      <th width="215"><div align="center">No Warna</div></th>
      <th width="215"><div align="center">Lot</div></th>
      <th width="215"><div align="center">Tgl Delivery</div></th>
      <th width="215"><div align="center">Roll</div></th>
      <th width="215"><div align="center">Kg</div></th>
	  <th width="215"><div align="center">Keterangan</div></th>
   </tr>
</thead>
<tbody>
  <?php 
  $c=0;
  $no=0;
	if($GShift=="ALL"){$shft=" ";}else{$shft=" g_shift='$GShift' AND ";}
	if($Awal!=""){$where=" DATE_FORMAT( tgl_update, '%Y-%m-%d %H:%i:%s' ) BETWEEN '$start_date' AND '$stop_date' ";}
	else{$where=" tgl_update='' ";}
  $sql=mysqli_query($con,"SELECT
	*
FROM
	tbl_schedule
WHERE	 
	$where
ORDER BY
	kapasitas DESC, no_mesin ASC, no_sch ASC, id DESC");	
  while($rowd=mysqli_fetch_array($sql)){
	 	$no++;
		$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	?>
   <tr bgcolor="<?php echo $bgcolor; ?>" class="table table-bordered table-hover table-striped">
     <td align="center"><?php echo $rowd['g_shift'];?></td>
     <td align="center"><?php echo $rowd['kapasitas'];?></td>
     <td align="center"><?php echo $rowd['no_mesin'];?></td>
     <td align="center"><?php echo $rowd['no_sch'];?></td>
     <td align="center"><?php echo $rowd['buyer'];?></td>
     <td align="center"><?php echo $rowd['no_order'];?></td>
     <td><?php echo $rowd['jenis_kain'];?></td>
     <td><?php echo $rowd['warna'];?></td>
     <td align="left"><?php echo $rowd['no_warna'];?></td>
     <td align="center"><?php echo $rowd['lot'];?></td>
     <td align="center"><?php echo $rowd['tgl_delivery'];?></td>
     <td align="center"><?php echo $rowd['rol'];?></td>
     <td align="right"><?php echo $rowd['bruto'];?></td>
     <td><i class="label bg-abu"><?php echo $rowd['ket_status'];?></i><br />
       <i class="label <?php if($rowd['status']=="antri mesin"){echo "bg-yellow";}else if($rowd['status']=="sedang jalan"){echo "bg-green";}else{echo "bg-red";} ?>"><?php echo $rowd['status'];?></i><br /><?php echo $rowd['ket'];?></td>
   </tr>
   <?php }?>
   </tbody>
   
</table>
</form>

      </div>
    </div>
  </div>
</div>
<div class="modal fade modal-super-scaled" id="PrintHalaman">
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cetak Schedule Per Halaman</h4>
              </div>
              <div class="modal-body">
				<a href="pages/cetak/cetak_schedule_p1.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 1</a>
				<a href="pages/cetak/cetak_schedule_p2.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 2</a>
				<a href="pages/cetak/cetak_schedule_p3.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 3</a>
				<a href="pages/cetak/cetak_schedule_p4.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 4</a>
				<a href="pages/cetak/cetak_schedule_p5.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 5</a><br><br>
				<a href="pages/cetak/cetak_schedule_p6.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 6</a>
				<a href="pages/cetak/cetak_schedule_p7.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 7</a>
				<a href="pages/cetak/cetak_schedule_p8.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 8</a>
				<a href="pages/cetak/cetak_schedule_p9.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 9</a>
				<a href="pages/cetak/cetak_schedule_p10.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 10</a><br><br>
				<a href="pages/cetak/cetak_schedule_p11.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 11</a>
				<a href="pages/cetak/cetak_schedule_p12.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 12</a>
				<a href="pages/cetak/cetak_schedule_p13.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 13</a>
				<a href="pages/cetak/cetak_schedule_p14.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 14</a>
				<a href="pages/cetak/cetak_schedule_p15.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 15</a><br><br>
				<a href="pages/cetak/cetak_schedule.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-warning" target="_blank"><i class="fa fa-print"></i> All Page</a> <a href="pages/cetak/schedule-celup-excel.php?Awal=<?php echo $start_date; ?>&Akhir=<?php echo $stop_date; ?>" class="btn btn-success" target="_blank"><i class="fa fa-file-excel-o"></i> All Page Excel</a>  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>
</body>
</html>