<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal=mysqli_query($con,"SELECT * FROM `tbl_std_jam` WHERE id='$modal_id' ");
while($r=mysqli_fetch_array($modal)){
?>
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_std" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Data Std Target</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
                  <div class="form-group">
                  <label for="jenis" class="col-md-3 control-label">Jenis Kain</label>
                  <div class="col-md-6">
                  <input name="jenis" class="form-control" value="<?php echo $r['jenis'];?>" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
				  <div class="form-group">
                  <label for="target" class="col-md-3 control-label">Target</label>
                  <div class="col-md-3">
					  <div class="input-group">
                  <input name="target" class="form-control" value="<?php echo $r['target'];?>" style="text-align: right;" required placeholder="0">
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
          <?php } ?>
