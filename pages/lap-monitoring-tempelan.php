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
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"> Filter Laporan Monitoring Tempelan</h3>
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
      <div class="form-group">
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>" autocomplete="off"/>
          </div>
        </div>
        <!-- /.input group -->
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
				 <!-- /.input group -->
              </div> 
      <div class="form-group">
                	<div class="col-sm-3"></div>
				 <!-- /.input group -->
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
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Data Monitoring Tempelan</h3><br><br>
        <?php if($_POST['awal']!="") { ?><b>Periode: <?php echo $_POST['awal']." to ".$_POST['akhir']; ?></b> 
		<a href="pages/cetak/monitoring-tempelan-excel.php?&awal=<?php echo $Awal; ?>&akhir=<?php echo $Akhir; ?>&shft=<?php echo $GShift; ?>" class="btn btn-danger pull-right" target="_blank"><i class="fa fa-print"></i> Cetak</a>  
		<?php } ?>
      
	  </div>
      <div class="box-body">
   

<table id="example2" class="table table-bordered table-hover" width="100%">
<thead class="btn-warning">
   <tr>
     <th width="33">Shift</th>
      <th width="53"><div align="center">Mesin</div></th>
      <th width="160"><div align="center">Buyer</div></th>
      <th width="111"><div align="center">Order</div></th>
      <th width="172"><div align="center">Warna</div></th>
      <th width="173"><div align="center">Proses</div></th>
      <th width="118"><div align="center">Lama Proses</div></th>
      <th width="66"><div align="center">Target</div></th>
	  <th width="274"><div align="center">Keterangan</div></th>
   </tr>
</thead>
<tbody>
  <?php 
  $c=0;
  $no=0;
  if($GShift=="ALL"){$shft=" ";}else{$shft=" c.g_shift='$GShift' AND ";}
  $sql=mysqli_query($con,"SELECT
	c.*,
	b.buyer,
	b.no_order,
	b.no_mesin,
	b.no_resep,
	b.warna,
	b.proses,
	b.target,
	if(c.status='selesai',a.lama_proses,TIME_FORMAT(timediff(now(),c.tgl_buat),'%H:%i')) as lama,
	a.operator_keluar,c.id as idm,b.id as ids
FROM
	tbl_montemp c
	LEFT JOIN tbl_schedule b ON c.id_schedule = b.id
	LEFT JOIN tbl_hasilcelup a ON a.id_montemp=c.id
WHERE
	$shft 
	DATE_FORMAT( c.tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir'
ORDER BY
	b.no_mesin ASC");	
  while($rowd=mysqli_fetch_array($sql)){
	 	$no++;
		$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	?>
   <tr bgcolor="<?php echo $bgcolor; ?>" class="table table-bordered table-hover table-striped">
     <td align="center"><?php echo $rowd['g_shift'];?></td>
     <td align="center"><?php echo $rowd['no_mesin'];?></td>
     <td align="center"><?php echo $rowd['buyer'];?></td>
     <td align="center"><?php echo $rowd['no_order'];?></td>
     <td><?php echo $rowd['warna'];?></td>
     <td align="left"><?php echo $rowd['proses'];?><br />
       <i class="label bg-hijau"><?php echo $rowd['operator'];?></i></td>
     <td align="center"><?php echo $rowd['lama'];?></td>
     <td align="center"><?php echo $rowd['target'];?></td>
     <td><i class="label bg-abu"><?php echo $rowd['nokk'];?></i><br>
       <i class="label <?php if($rowd['status']=="antri mesin"){echo "bg-yellow";}else if($rowd['status']=="sedang jalan"){echo "bg-green";}else{echo "bg-red";} ?>"><?php echo $rowd['status'];?></i>
	   <?php if($rowd['status']=="selesai"){ ?><br><i class="label bg-green"><?php echo $rowd['operator_keluar'];?></i><?php } ?><br>
	   <?php echo $rowd['ket'];?><br><div class="btn-group"><?php if($rowd['no_mesin']=="WS"){ ?> <a href="pages/cetak/cetak_monitoring.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&idm=<?php echo $rowd['idm'];?>&ids=<?php echo $rowd['ids'];?>" target="_blank" class="btn btn-xs btn-warning">Monitoring</a> <a href="pages/cetak/cetak.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&idm=<?php echo $rowd['idm'];?>&ids=<?php echo $rowd['ids'];?>" target="_blank" class="btn btn-xs btn-success">Tempelan</a> <a href="pages/cetak/cetak_depan.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&idm=<?php echo $rowd['idm'];?>&ids=<?php echo $rowd['ids'];?>" target="_blank" class="btn btn-xs btn-warning">Relaxing</a> <?php }else if($rowd['no_mesin']=="CB"){ ?> <a href="pages/cetak/cetak_monitoring.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&idm=<?php echo $rowd['idm'];?>&ids=<?php echo $rowd['ids'];?>" target="_blank" class="btn btn-xs btn-warning">Monitoring</a> <a href="pages/cetak/cetak.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&idm=<?php echo $rowd['idm'];?>&ids=<?php echo $rowd['ids'];?>" target="_blank" class="btn btn-xs btn-success">Tempelan</a> <a href="pages/cetak/cetak_depan_cb.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&idm=<?php echo $rowd['idm'];?>&ids=<?php echo $rowd['ids'];?>" target="_blank" class="btn btn-xs btn-primary">C-Bleaching</a><?php }else{ ?> <a href="pages/cetak/cetak_monitoring.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&idm=<?php echo $rowd['idm'];?>&ids=<?php echo $rowd['ids'];?>" target="_blank" class="btn btn-xs btn-warning">Monitoring</a> <a href="pages/cetak/cetak.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&idm=<?php echo $rowd['idm'];?>&ids=<?php echo $rowd['ids'];?>" target="_blank" class="btn btn-xs btn-success">Tempelan</a> <?php } ?> <a href="pages/cetak/simpan_cetak.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&id=" target="_blank" class="btn btn-xs btn-info">Resep</a><a href="pages/cetak/iden_produk.php?idkk=<?php echo $rowd['nokk'];?>&no=<?php echo $rowd['no_resep'];?>&idm=<?php echo $rowd['idm'];?>&ids=<?php echo $rowd['ids'];?>" target="_blank" class="btn btn-xs btn-danger">Iden-Pro</a></div></td>
   </tr>
   <?php }?>
   </tbody>
   
</table>
</form>

      </div>
    </div>
  </div>
</div>

</body>
</html>