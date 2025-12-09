<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal=mysqli_query($con,"SELECT * FROM `tbl_dokumen` WHERE id='$modal_id' ");
while($r=mysqli_fetch_array($modal)){
?>
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_sts_dok_simpan" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Status</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
				  <div class="form-group">
                  <label for="sts" class="col-md-3 control-label">Status</label>
                  <div class="col-md-6">
                  <select name="sts" class="form-control" id="sts">
							  	<option value="">Pilih</option>
					  			<option value="OK" <?php if($r['sts']=="OK"){ echo "SELECTED"; }?>>OK</option>
					  			<option value="Pending" <?php if($r['sts']=="Pending"){ echo "SELECTED"; }?>>Pending</option>
					  			<option value="Review" <?php if($r['sts']=="Review"){ echo "SELECTED"; }?>>Review</option>
					  			<option value="Cancel" <?php if($r['sts']=="Cancel"){ echo "SELECTED"; }?>>Cancel</option>
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
