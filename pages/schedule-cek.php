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
<script>
function aktif(){
		if(document.forms['form1']['ck'].checked == true){
		document.form1.nokk.setAttribute("readonly",true);
		document.form1.nokk.removeAttribute("required");		
		document.form1.nokk.value="";	
		}
		else{
		document.form1.nokk.removeAttribute("readonly");
		document.form1.nokk.setAttribute("required",true);	
		}
	}	

</script>
</head>
<body>
<?php
$nokk	= isset($_POST['nokk']) ? $_POST['nokk'] : '';
$ck		= isset($_POST['ck']) ? $_POST['ck'] : '';	
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"> Filter Cek Schedule Per NOKK</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1">
    <div class="box-body">
      <div class="form-group">
          <div class="col-sm-2">
				  <input name="nokk" type="text" class="form-control" id="nokk" value="<?php echo $nokk;?>" placeholder="No KK" <?php if($ck==1){echo"readonly";} ?>>	  
		  </div>
		  <div class="col-sm-2">
				  <input type="checkbox" value="1" id="ck" name="ck" <?php if($ck==1){echo "CHECKED"; } ?> onClick="aktif();"/> Semua  
		  </div>
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
        <h3 class="box-title">Data Schedule</h3> 
		<?php if($ck==1){?>  
		<a href="#" onclick="confirm_delAll('?p=sch1_semua_hapus');" class="btn btn-danger <?php if($_SESSION['lvl_id10']=="3" or $rCEk['idb']!=""){echo "disabled"; } ?> pull-right"><i class="fa fa-trash"></i> Hapus Semua</a> 
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
	  <?php if($ck==1){  ?>
      <th width="224"><div align="center">Nokk</div></th>
	  <?php } ?>	  
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
	if($ck=="1"){$nokk="";}else{ $nokk=" a.nokk='$nokk' and ";}
  $c=0;
  $no=0;
/*$sql=mysqli_query("SELECT a.* FROM tbl_schedule a
INNER JOIN tbl_montemp b ON a.id=b.id_schedule 
WHERE $nokk ((a.`status`='selesai' AND b.`status`='sedang jalan') or (a.`status`='sedang jalan' AND b.`status`='selesai') or (mc_from='' and no_urut='' and no_mesin='' and (a.`status`='sedang jalan' or a.`status`='antri mesin')))");*/	
	
  $sql=mysqli_query($con,"SELECT a.* FROM tbl_schedule a
INNER JOIN tbl_montemp b ON a.id=b.id_schedule 
WHERE $nokk ((not a.`status`=b.`status`) or (mc_from='' and no_urut='' and no_mesin='' and (a.`status`='sedang jalan' or a.`status`='antri mesin')))");	
  while($rowd=mysqli_fetch_array($sql)){
	 	$no++;
		$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	?>
   <tr bgcolor="<?php echo $bgcolor; ?>" class="table table-bordered table-hover table-striped">
     <td align="center"><?php echo $rowd['g_shift'];?><br>
	   <a href="#" onclick="confirm_del('?p=sch1_hapus&id=<?php echo $rowd['id'] ?>');" class="btn btn-xs btn-danger <?php if($_SESSION['lvl_id10']=="3" or $rCEk['idb']!=""){echo "disabled"; } ?>"><i class="fa fa-trash"></i> </a></td>
     <td align="center"><?php echo $rowd['kapasitas'];?></td>
     <td align="center"><?php echo $rowd['no_mesin'];?></td>
     <td align="center"><?php echo $rowd['no_sch'];?></td>
	 <?php if($ck==1){ ?>  
     <td align="center"><?php echo $rowd['nokk'];?></td>
	 <?php } ?>  
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
<!-- Modal Popup untuk delete-->
	<div class="modal fade" id="delSchedule" tabindex="-1">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content" style="margin-top:100px;">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
		  </div>

		  <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
			<a href="#" class="btn btn-danger" id="del_link">Delete</a>
			<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="delScheduleAll" tabindex="-1">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content" style="margin-top:100px;">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" style="text-align:center;">Are you sure to delete this ALL information ?</h4>
		  </div>

		  <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
			<a href="#" class="btn btn-danger" id="del_link1">Delete</a>
			<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
	  </div>
	</div>
</body>
</html>
<script type="text/javascript">
              function confirm_del(delete_url) {
                $('#delSchedule').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('del_link').setAttribute('href', delete_url);
              }
			  function confirm_delAll(delete_url) {
                $('#delScheduleAll').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('del_link1').setAttribute('href', delete_url);
              }
            </script>