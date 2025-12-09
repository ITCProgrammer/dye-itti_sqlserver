<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Status Data Test</title>
</head>

<body>
<?php
   $data=mysqli_query($con,"SELECT * FROM tbl_datatest WHERE no_test != ''
ORDER BY
	id ASC");
	$no=1;
	$n=1;
	$c=0;
	 ?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
<div class="box-header">
  <!-- <a href="?p=Form-Setting-Mesin" class="btn btn-success <?php if($_SESSION['lvl_id10']=="3"){ echo "disabled";} ?>"><i class="fa fa-plus-circle"></i> Tambah</a> -->
  <!-- <a href="#" data-toggle="modal" data-target="#PrintHalaman" class="btn btn-danger pull-right"><i class="fa fa-print"></i> Cetak</a> -->
		</div>	
      <div class="box-body">
<table id="example1" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th width="26" rowspan="2"><div align="center">Tgl Test</div></th>
			  <th width="26" rowspan="2"><div align="center">No Test</div></th>
			  <th width="15" rowspan="2"><div align="center">Item</div></th>
              <th width="20" rowspan="2"><div align="center">No KK</div></th>
			  <th width="30" rowspan="2"><div align="center">No Demand</div></th>
			  <th width="30" rowspan="2"><div align="center">No Prod. Order</div></th>
              <th width="30" rowspan="2"><div align="center">No PO</div></th>
			  <th width="30" rowspan="2"><div align="center">Buyer</div></th>
			  <th width="20" rowspan="2"><div align="center">No Order</div></th>
			  <th width="70" rowspan="2"><div align="center">Jenis Kain</div></th>
			  <th width="50" rowspan="2"><div align="center">Warna</div></th>
			  <th width="50" rowspan="2"><div align="center">No Warna</div></th>
			  <th width="20" rowspan="2"><div align="center">Lebar</div></th>
			  <th width="20" rowspan="2"><div align="center">Gramasi</div></th>
			  <th width="20" colspan="2"><div align="center">Qty</div></th>
			  <th width="30" rowspan="2"><div align="center">Lot</div></th>
              <th width="15" rowspan="2"><div align="center">Masalah</div></th>
              <th width="15" rowspan="2"><div align="center">Improve</div></th>
			  <th width="20" rowspan="2"><div align="center">No MC</div></th>
			  <th width="20" rowspan="2"><div align="center">Tgl Celup</div></th>
			  <th width="20" rowspan="2"><div align="center">Loading %</div></th>
			  <th width="20" rowspan="2"><div align="center">L : R</div></th>
			  <th width="40" rowspan="2"><div align="center">No Program</div></th>
			  <th width="40" colspan="2"><div align="center">RPM</div></th>
			  <th width="40" colspan="2"><div align="center">Cycle Time</div></th>
			  <th width="40" colspan="2"><div align="center">Tekanan/Press</div></th>
			  <th width="40" colspan="2"><div align="center">Nozzle</div></th>
			  <th width="40" colspan="2"><div align="center">Plaiter</div></th>
			  <th width="40" colspan="2"><div align="center">Blower</div></th>
			  <th width="40" rowspan="2"><div align="center">Grafik</div></th>
			  <th width="30" rowspan="2"><div align="center">Keterangan Proses</div></th>
			  <th width="20" rowspan="2"><div align="center">Hasil QC</div></th>
			  <th width="20" rowspan="2"><div align="center">Cek Shading</div></th>
			  <th width="20" rowspan="2"><div align="center">Inspect Report</div></th>
			  <th width="20" rowspan="2"><div align="center">Update Status</div></th>
            </tr>
			<tr>
				<th width="10"><div align="center">Roll</div></th>
				<th width="10"><div align="center">KG</div></th>
				<th width="10"><div align="center">Setting</div></th>
				<th width="10"><div align="center">Aktual</div></th>
				<th width="10"><div align="center">Setting</div></th>
				<th width="10"><div align="center">Aktual</div></th>
				<th width="10"><div align="center">Setting</div></th>
				<th width="10"><div align="center">Aktual</div></th>
				<th width="10"><div align="center">Setting</div></th>
				<th width="10"><div align="center">Aktual</div></th>
				<th width="10"><div align="center">Setting</div></th>
				<th width="10"><div align="center">Aktual</div></th>
				<th width="10"><div align="center">Setting</div></th>
				<th width="10"><div align="center">Aktual</div></th>
			</tr>
          </thead>
          <tbody>
            <?php
	  $col=0;
  while($rowd=mysqli_fetch_array($data)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  	$qMT=mysqli_query($con,"SELECT rpm, cycle_time, tekanan, nozzle, blower, plaiter, tgl_buat FROM tbl_montemp WHERE nokk='$rowd[nokk]'");
	  	$rMT=mysqli_fetch_array($qMT);
		 ?>
            <tr bgcolor="<?php echo $bgcolor; ?>">
              <td align="center"><?php echo date("d/m/y", strtotime($rowd['tgl_buat']));?></td>
			  <td align="center"><?php echo $rowd['no_test'];?></td>
			  <td align="center"><?php echo $rowd['no_item'];?></td>
			  <td align="center"><?php echo $rowd['nokk'];?></td>
			  <td align="center"><?php echo $rowd['demand_erp'];?></td>
			  <td align="center"><?php echo $rowd['prodorder_erp'];?></td>
			  <td align="center"><?php echo $rowd['po'];?></td>
			  <td align="center"><?php echo $rowd['buyer'];?></td>
			  <td align="center"><?php echo $rowd['no_order'];?></td>
			  <td><?php echo $rowd['jenis_kain'];?></td>
			  <td align="center"><?php echo $rowd['warna'];?></td>
			  <td align="center"><?php echo $rowd['no_warna'];?></td>
			  <td align="center"><?php echo $rowd['lebar'];?></td>
			  <td align="center"><?php echo $rowd['gramasi'];?></td>
			  <td align="center"><?php echo $rowd['roll'];?></td>
			  <td align="center"><?php echo $rowd['bruto'];?></td>
			  <td align="center"><?php echo $rowd['lot'];?></td>
			  <td align="center"><?php echo $rowd['masalah'];?></td>
			  <td align="center"><?php echo $rowd['improve'];?></td>
			  <td align="center"><?php echo $rowd['no_mesin'];?></td>
			  <td align="center"><?php echo date("d/m/y", strtotime($rMT['tgl_buat']));?></td>
			  <td align="center"><?php echo $rowd['loading'];?></td>
			  <td align="center"><?php echo $rowd['l_r'];?></td>
			  <td align="center"><?php echo $rowd['no_program'];?></td>
			  <td align="center"><?php echo $rowd['rpm'];?></td>
			  <td align="center"><?php echo $rMT['rpm'];?></td>
			  <td align="center"><?php echo $rowd['cycle_time'];?></td>
			  <td align="center"><?php echo $rMT['cycle_time'];?></td>
			  <td align="center"><?php echo $rowd['tekanan'];?></td>
			  <td align="center"><?php echo $rMT['tekanan'];?></td>
			  <td align="center"><?php echo $rowd['nozzle'];?></td>
			  <td align="center"><?php echo $rMT['nozzle'];?></td>
			  <td align="center"><?php echo $rowd['blower'];?></td>
			  <td align="center"><?php echo $rMT['blower'];?></td>
			  <td align="center"><?php echo $rowd['plaiter'];?></td>
			  <td align="center"><?php echo $rMT['plaiter'];?></td>
			  <td align="center">&nbsp;</td>
			  <td align="center"><?php echo $rowd['ket_proses'];?></td>
			  <td align="center"><?php echo $rowd['hasil_qc'];?></td>
			  <td align="center"><?php echo $rowd['cek_shading'];?></td>
			  <td align="center">&nbsp;</td>
			  <td align="center"><?php echo $rowd['update_status'];?></td>
            </tr>
            <?php
						$no++;
  } ?>
          </tbody>
          <tfoot class="bg-red">
          </tfoot>
        </table>
		</div>
	  </div>
	</div>
</div>
<div class="modal fade modal-super-scaled" id="PrintHalaman">
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cetak Schedule Per Halaman</h4>
              </div>
              <div class="modal-body">
				<a href="pages/cetak/cetak_schedule_p1.php" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 1</a>
				<a href="pages/cetak/cetak_schedule_p2.php" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 2</a>
				<a href="pages/cetak/cetak_schedule_p3.php" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 3</a>
				<a href="pages/cetak/cetak_schedule_p4.php" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 4</a>
				<a href="pages/cetak/cetak_schedule_p5.php" class="btn btn-danger" target="_blank"><i class="fa fa-print"></i> Page 5</a><br><br>
				<a href="pages/cetak/cetak_schedule_p6.php" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 6</a>
				<a href="pages/cetak/cetak_schedule_p7.php" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 7</a>
				<a href="pages/cetak/cetak_schedule_p8.php" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 8</a>
				<a href="pages/cetak/cetak_schedule_p9.php" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 9</a>
				<a href="pages/cetak/cetak_schedule_p10.php" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Page 10</a><br><br>
				<a href="pages/cetak/cetak_schedule_p11.php" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 11</a>
				<a href="pages/cetak/cetak_schedule_p12.php" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 12</a>
				<a href="pages/cetak/cetak_schedule_p13.php" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 13</a>
				<a href="pages/cetak/cetak_schedule_p14.php" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 14</a>
				<a href="pages/cetak/cetak_schedule_p15.php" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Page 15</a>
				<br><br>
				<a href="pages/cetak/cetak_schedule_p16.php" class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Page 16</a>  
				<a href="pages/cetak/cetak_schedule_p17.php" class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Page 17</a><br><br>
				<a href="pages/cetak/cetak_schedule.php" class="btn btn-warning" target="_blank"><i class="fa fa-print"></i> All Page</a> <a href="pages/cetak/schedule-celup-excel.php" class="btn btn-success" target="_blank"><i class="fa fa-file-excel-o"></i> All Page Excel</a>  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
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
	
	<div id="ScheduleEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>
	<div id="EditStatusMesin" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>
	<div id="Resep" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>	
	<div id="DetailKartu" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
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

            </script>