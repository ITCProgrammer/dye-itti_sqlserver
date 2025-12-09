<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$qry1=mysqli_query($con,"SELECT nama_dokumen,no_dokumen FROM tbl_dokumen WHERE id='$_GET[id]'");
$row=mysqli_fetch_array($qry1)
?>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Nama Dokumen :
        <?php echo $row['nama_dokumen'];?><br>No Dokumen :
        <?php echo $row['no_dokumen'];?>
      </h4>
    </div>
    <div class="modal-body table-responsive">
      <table id="tbl3" class="table table-bordered table-hover display" width="100%">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="21%">Tanggal</th>
            <th width="55%">Catatan</th>
            <th width="19%">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php

        $qry=mysqli_query($con,"SELECT * FROM tbl_dokumen_detail WHERE id_dokumen='$_GET[id]' ORDER BY id DESC");
   $no=1;

   $c=0;
    while ($rowd=mysqli_fetch_array($qry)) {
        $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
        
			?>
          <tr>
            <td align="center">
              <?php echo $no; ?>
            </td>
            <td>
              <?php echo $rowd['tgl_status']; ?>
            </td>
            <td><?php echo $rowd['catatan']; ?></td>
            <td bgcolor="<?php if ($rowd['sts']=="Masuk") { echo " green"; }else if ($rowd['sts']=="Keluar") { echo " red"; }?>" >
              <?php if ($rowd['sts']!="") { echo "<font color=white>$rowd[sts]</font>"; } ?>
            </td>
          </tr>
          <?php $no++;
    } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(function() {
    $("#tbl3").dataTable({
        'paging': false,
        'ordering': false,
        'info': false,
        'searching': false
      });
  });

</script>
