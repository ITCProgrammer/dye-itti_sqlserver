<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$modal_id=$_GET['id'];
$posisi=strpos($modal_id,".");
$posisi1=strpos($modal_id,",");
$id=substr($modal_id,0,$posisi);
$awal=substr($modal_id,$posisi+1,10);
$akhir=substr($modal_id,$posisi1+1,10);
echo $modal_id;
	$modal=mysqli_query($cond,"SELECT * FROM `tbl_ncp_qcf` WHERE `id`='$id' ");
while($r=mysqli_fetch_array($modal)){
?>
         
<div class="modal-dialog modal1">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_analisa" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Analisa </h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
				  <input type="hidden" id="awal" name="awal" value="<?php echo $awal;?>">
				  <input type="hidden" id="akhir" name="akhir" value="<?php echo $akhir;?>">
				  <div class="form-group">
                  <label for="no_resep" class="col-md-4 control-label">Analisa Penyebab</label>
                  <div class="col-md-7"> 
				  <textarea name="analisa_penyebab" rows="5" class="form-control" id="analisa_penyebab"><?php echo $r['analisa_penyebab'];?></textarea>	  
                  </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <!--<button type="submit" class="btn btn-primary" value="Submit" name="save">Save</button>-->
				<input type="submit" class="btn btn-primary" value="Save" name="save">
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
          <?php } ?>
<script>
//Date picker
        $('#datepicker').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
        });	
//Timepicker
    	$('#timepicker').timepicker({
      	showInputs: false,
    	});
	    
	$(function () {	
//Timepicker
    $('.timepicker').timepicker({
                minuteStep: 1,
                showInputs: true,
                showMeridian: false,
                defaultTime: false	
	  	
    }),
		
});
	

</script>
