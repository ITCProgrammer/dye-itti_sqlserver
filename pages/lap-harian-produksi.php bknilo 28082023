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
    <h3 class="box-title"> Filter Laporan Harian Produksi</h3>
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
            <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>" autocomplete="off"/>
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
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Data Produksi Celup</h3><br><br>
        <?php if($_POST['awal']!="") { ?><b>Periode: <?php echo $start_date." to ".$stop_date; ?></b> 
		<div class="btn-group pull-right">
		  <a href="pages/cetak/reports-harian-produksi.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-danger " target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi"><i class="fa fa-print"></i> </a>
		<a href="pages/cetak/reports-harian-produksi-excel.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-success " target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Excel"><i class="fa fa-file-excel-o"></i> </a>
		<a href="pages/cetak/reports-harian-produksi-opt-excel.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-primary " target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Waktu Tunggu Excel"><i class="fa fa-file-excel-o"></i> </a>	
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
     <th width="38">Shift</th>
      <th width="224"><div align="center">Buyer</div></th>
      <th width="314"><div align="center">Order</div></th>
	  <th width="404"><div align="center">Jenis Kain</div></th>
	  <th width="404"><div align="center">Lot</div></th> 
      <th width="404"><div align="center">Warna</div></th>
      <th width="215"><div align="center">Proses</div></th>
      <th width="215"><div align="center">Aktual Proses</div></th>
      <th width="215"><div align="center">Lama Proses</div></th>
      <th width="215"><div align="center">Std Target</div></th>
      <th width="215"><div align="center">Keterangan</div></th>
   </tr>
</thead>
<tbody>
  <?php   	
  $c=0;
  $no=0;
	if($GShift=="ALL"){$shft=" ";}else{$shft=" if(ISNULL(a.g_shift),c.g_shift,a.g_shift)='$GShift' AND ";}
	/*if($Awal!=""){$Where="( DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$start_date' AND '$stop_date' OR b.`status`='sedang jalan') OR
	((b.ket_status='MC Stop' OR b.ket_status='Cuci Mesin' OR b.ket_status='MC Rusak') AND b.`status`='antri mesin') ";}else{$Where=" c.tgl_update='$Awal' ";}*/
	/*if($Awal!=$Akhir){ $Where=" DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$start_date' AND '$stop_date' ";}else{
		$Where=" DATE_FORMAT(c.tgl_update, '%Y-%m-%d')='$Awal' ";
	}*/
	$Where=" DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$start_date' AND '$stop_date' ";
	if($Awal!="" and $Akhir!=""){ $Where1=" ";}else{ $Where1=" WHERE a.id='' ";}
  $sql=mysqli_query($con,"
  SELECT x.*,a.no_mesin as mc,a.no_mc_lama as mc_lama FROM tbl_mesin a
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
  b.target,
	if(ISNULL(a.g_shift),c.g_shift,a.g_shift) as shft,
	c.operator,	if(c.status='selesai',if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))),TIME_FORMAT(timediff(now(),c.tgl_buat),'%H:%i')) as lama,
	b.`status` as sts,
	a.`status` as stscelup,
	a.proses as proses_aktual,
	a.id as idclp
FROM
	tbl_schedule b
	LEFT JOIN  tbl_montemp c ON c.id_schedule = b.id
	LEFT JOIN tbl_hasilcelup a ON a.id_montemp=c.id
WHERE
	$shft
	$Where
	) x ON (a.no_mesin=x.no_mesin or a.no_mc_lama=x.no_mesin) $Where1 ORDER BY a.no_mesin ");	
  while($rowd=mysqli_fetch_array($sql)){
    if($GShift=="ALL"){$shftSM=" ";}else{$shftSM=" g_shift='$GShift' AND ";}
    $sqlSM=mysqli_query($con,"SELECT *, g_shift as shiftSM, TIME_FORMAT(timediff(selesai,mulai),'%H:%i') as lamaSM FROM tbl_stopmesin
    WHERE $shftSM tgl_update BETWEEN '$start_date' AND '$stop_date' AND (no_mesin='$rowd[mc]' or no_mesin='$rowd[mc_lama]') ORDER BY id DESC LIMIT 1");
    $rowSM=mysqli_fetch_array($sqlSM);
	 	$no++;
		$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  	$qCek=mysqli_query($con,"SELECT id as idb FROM tbl_potongcelup WHERE nokk='$rowd[nokk]' LIMIT 1");
	  	$rCEk=mysqli_fetch_array($qCek);
	?>
   <tr bgcolor="<?php echo $bgcolor; ?>" class="table table-bordered table-hover table-striped">
     <td align="center"><?php echo $rowd['mc'];?><br><div class="btn-group <?php if($rCEk['idb']==""){ echo "hidden";} ?>"><a href="pages/cetak/cetak_celup.php?id=<?php echo $rCEk['idb'] ?>" class="btn btn-xs btn-warning" target="_blank"><i class="fa fa-print"></i> </a><a href="#" id='<?php echo $rowd['idclp']; ?>' class="btn btn-xs btn-info edit_stscelup"><i class="fa fa-edit"></i> </a></div></td>
     <td align="center"><?php if($rowd['no_order']=="" AND substr($rowd['proses'],0,10)!="Cuci Mesin"){ echo $rowSM['shiftSM'];}else{echo $rowd['shft'];}?></td>
     <td align="center"><?php echo $rowd['buyer'];?></td>
     <td align="center"><?php echo $rowd['no_order'];?></td>
	 <td><?php echo $rowd['jenis_kain'];?></td>
	 <td align="center"><?php echo $rowd['lot'];?></td>  
     <td><?php echo $rowd['warna'];?></td>
     <td align="left"><?php if($rowd['no_order']=="" AND substr($rowd['proses'],0,10)!="Cuci Mesin"){ echo $rowSM['proses'];}else{echo $rowd['proses'];}?><br />
       <i class="label bg-hijau"><?php if($rowd['operator_keluar']!=""){echo $rowd['operator_keluar'];}else{ echo $rowd['operator'];}?></i></td>
     <td align="center"><?php echo $rowd['proses_aktual'];?></td>
     <td align="center"><?php if($rowd['no_order']=="" AND substr($rowd['proses'],0,10)!="Cuci Mesin"){ echo $rowSM['lamaSM'];}else{echo $rowd['lama'];}?></td>
     <td align="center"><?php echo $rowd['target'];?></td> 
     <td><i class="label bg-abu"><?php if($rowd['no_order']=="" AND substr($rowd['proses'],0,10)!="Cuci Mesin"){ echo $rowSM['no_stop']."<br>".$rowSM['keterangan'];}else{echo $rowd['nokk'];}?></i><br />
       <i class="label <?php if($rowd['stscelup']=="OK"){echo "bg-green";}else if($rowd['stscelup']=="Gagal Proses"){echo "bg-red";} ?>"> <?php echo $rowd['stscelup'];?> </i><br /><?php echo $rowd['ket'];?></td>
   </tr>
   <?php }?>
   </tbody>
   
</table>
</form>

      </div>
    </div>
  </div>
</div>
<div id="EditStsCelup" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>	
<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	</script>
</body>
</html>