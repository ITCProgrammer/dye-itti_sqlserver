<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal=mysqli_query($con,"SELECT * FROM `tbl_hasilcelup` WHERE id='$modal_id' ");
while($r=mysqli_fetch_array($modal)){
?>
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_shift" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Status</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
				  <div class="form-group">
                  <label for="sts" class="col-md-3 control-label">Status</label>
                  <div class="col-md-8">
                  <select name="sts" class="form-control" id="sts">
							  	<option value="">Pilih</option>
					  			<option value="OK" <?php if($r['status']=="OK"){ echo "SELECTED";}?>>OK</option>
					  			<option value="Gagal Proses" <?php if($r['status']=="Gagal Proses"){ echo "SELECTED";}?>>Gagal Proses</option>
					  			<option value="Tolak Basah" <?php if($r['status']=="Tolak Basah"){ echo "SELECTED";}?>>Tolak Basah</option>
					  			<option value="Tolak Basah Luntur" <?php if($r['status']=="Tolak Basah Luntur"){ echo "SELECTED";}?>>Tolak Basah Luntur</option>
				  </select>
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
          <?php } ?>
