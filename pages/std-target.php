<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Std Target</title>
</head>

<body>
<?php
   $data=mysqli_query($con,"SELECT * FROM tbl_std_jam ORDER BY id ASC");
	$no=1;
	$n=1;
	$c=0;
	 ?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
<div class="box-header">
  <a href="#" data-toggle="modal" data-target="#DataStdTarget" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add</a>
      </div>
      <div class="box-body">
<table width="100%" class="table table-bordered table-hover display" id="example2">
 <thead class="bg-blue">
  <tr align="center">
    <td width="3%"><strong>No</strong></td>
    <td width="25%"><strong>Kode</strong></td>
    <td width="33%"><strong>Jenis Kain</strong></td>
    <td width="25%"><strong>Target (Jam)</strong></td>
    <td width="14%"><strong>Action</strong></td>
  </tr>
  </thead>
  <tbody>
  <?php
	  $col=0;
  while($rowd=mysqli_fetch_array($data)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
		 ?>
  <tr align="center" bgcolor="<?php echo $bgcolor; ?>">
    <td><?php echo $no;?></td>
    <td><?php echo $rowd['kode'];?></td>
    <td><?php echo $rowd['jenis'];?></td>
    <td><?php echo $rowd['target'];?></td>
    <td><div class="btn-group">
		<a href="#" id='<?php echo $rowd['id'] ?>' class="btn btn-info std_edit"><i class="fa fa-edit"></i> </a>
		<a href="#" onclick="confirm_del('?p=std_hapus&id=<?php echo $rowd['id'] ?>');" class="btn btn-danger"><i class="fa fa-trash"></i> </a>
		</div></td>
  </tr>
  <?php
  $no++;} ?>
  </tbody>
</table>
<div class="modal fade modal-super-scaled" id="DataStdTarget">
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=simpan_std" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Std Target</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                  <label for="kode" class="col-md-3 control-label">Kode</label>
                  <div class="col-md-3">
                  <select name="kode" class="form-control" required>
							  	<option value="">Pilih</option>
							  	<option value="D">D</option>
							    <option value="R">R</option>
							  	<option value="D+R">D+R</option>
							  	<option value="OBA">OBA</option>
					  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="jenis" class="col-md-3 control-label">Jenis Kain</label>
                  <div class="col-md-6">
                  <input name="jenis" class="form-control" value="" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="target" class="col-md-3 control-label">Target</label>
                  <div class="col-md-3">
					  <div class="input-group">
                  <input name="target" class="form-control" value="" style="text-align: right;" required placeholder="0">
					  <span class="input-group-addon">Jam</span></div>	  
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>				  
                  
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Save</button>
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>
<!-- Modal Popup untuk Edit-->
<div id="StdEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Modal Popup untuk delete-->
	<div class="modal fade" id="delStaff" tabindex="-1">
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
</body>
</html>
<script type="text/javascript">
              function confirm_del(delete_url) {
                $('#delStaff').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('del_link').setAttribute('href', delete_url);
              }

            </script>