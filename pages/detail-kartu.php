<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$qCek=mysqli_query($con,"SELECT no_mesin,no_urut FROM tbl_schedule WHERE id='$_GET[id]'");
$rCek=mysqli_fetch_array($qCek);
?>
<div class="modal-dialog modal-lg" style="width: 92%;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">No Mesin a:
        <?php echo $rCek['no_mesin'];?> <br> No Urut : <?php echo $rCek['no_urut'];?> 
      </h4>
    </div>
    <div class="modal-body">
      <table id="tbl2" class="table table-bordered table-hover table-striped" width="100%">
        <thead>
          <tr>
            <td><div align="center">No</div></td>
            <td><div align="center">No KK</div></td>
            <td><div align="center">Buyer</div></td>
            <td><div align="center">Costumer</div></td>
            <td><div align="center">PO</div></td>
            <td><div align="center">Order</div></td>
            <td><div align="center">Lot</div></td>
            <td><div align="center">Warna</div></td>
            <td><div align="center">Proses</div></td>
            <td><div align="center">Tgl Delivery</div></td>
            <td><div align="center">Ket</div></td>
            <td><div align="center">Status</div></td>
            <td><div align="center">Aksi</div></td>
          </tr>
        </thead>
        <tbody>
          <?php

        $qry=mysqli_query($con," SELECT *,IF(DATEDIFF(now(),tgl_delivery) > 0,'Urgent',
IF(DATEDIFF(now(),tgl_delivery) > -4,'Potensi Delay','')) as `sts` FROM tbl_schedule a WHERE a.no_mesin='$rCek[no_mesin]' AND a.no_urut='$rCek[no_urut]' AND NOT `status` = 'selesai' ORDER BY a.no_urut ASC ");
   $no=1;

   $c=0;
    while ($rowd=mysqli_fetch_array($qry)) {
        $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
        $qCek=mysqli_query($con,"SELECT id as idb FROM tbl_montemp WHERE nokk='$rowd[nokk]' LIMIT 1");
	  	$rCEk=mysqli_fetch_array($qCek);
			?>
          <tr align="center">
            <td>
              <?php echo $no; ?>
            </td>
            <td>
              <?php echo $rowd['nokk']; ?>
            </td>
            <td><?php echo $rowd['buyer']; ?></td>
            <td><?php echo $rowd['langganan']; ?></td>
            <td><?php echo $rowd['po']; ?></td>
            <td><?php echo $rowd['no_order']; ?></td>
            <td><?php echo $rowd['lot']; ?></td>
            <td><?php echo $rowd['warna']; ?></td>
            <td><?php echo $rowd['proses']; ?></td>
            <td>
              <?php echo $rowd['tgl_delivery']; ?>
            </td>
            <td bgcolor="<?php echo $bg; ?>"><?php echo $rowd['ket_status']; ?><br><span class="label <?php if($rowd['status']=="sedang jalan"){echo "label-success";}else{echo "label-warning";} ?>"><?php echo $rowd['status']; ?></span></td>
            <td bgcolor="<?php if ($rowd['sts']=="Potensi Delay") { echo " orange"; }else if ($rowd['sts']=="Urgent") { echo " red"; }?>" >
              <?php if ($rowd['sts']!="") { echo "<font color=white>$rowd[sts]</font>"; } ?>
            </td>
            <td><div class="btn-group"><a href="#" id='<?php echo $rowd['id']; ?>' class="btn btn-xs btn-info schedule_edit1 <?php if($_SESSION['lvl_id10']=="3"){echo "disabled"; } ?>"><i class="fa fa-edit"></i> </a><a href="#" onclick="confirm_del1('?p=sch_hapus&id=<?php echo $rowd['id'] ?>');" class="btn btn-xs btn-danger <?php if($_SESSION['lvl_id10']=="3" or $rCEk['idb']!=""){echo "disabled"; } ?>"><i class="fa fa-trash"></i> </a></div></td>
          </tr>
          <?php $no++;
    } ?>
        </tbody>
      </table>		
    </div>
	<!-- Modal Popup untuk delete-->
	<div class="modal fade" id="delSchedule1" tabindex="-1">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content" style="margin-top:100px;">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
		  </div>

		  <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
			<a href="#" class="btn btn-danger" id="del_link1">Delete</a>
			<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
	  </div>
	</div>
	<div id="ScheduleEdit1" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>
  </div>
</div>
<script>
$(function() {
	$('#tbl2').dataTable(
	{
	  "pageLength" : 3,
      "lengthMenu": [[3, 5, 10, 25, 50, 100], [3, 5, 10, 25, 50, 100]]
	});
    $('#tbl3').dataTable({
		'scrollX'  : true,
	  	'scrollY'  : '350px',	
	  	'paging'	 : false,
        });
  });
</script>
<script type="text/javascript">
  
  function confirm_del1(delete_url) {
                $('#delSchedule1').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('del_link1').setAttribute('href', delete_url);
              }
</script>
