<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hasil-Celup</title>
</head>

<body>
<?php
   $data=mysqli_query($con,"SELECT a.masalah,a.inspektor,a.tidakan_perbaikan,b.operator_keluar,b.proses,b.shift,b.g_shift,c.nokk,d.no_order,d.no_mesin,d.buyer,d.warna
FROM tbl_masalah_celupan a
inner join tbl_hasilcelup b on a.id_hasilcelup=b.id
inner join tbl_montemp c on b.id_montemp=c.id
inner join tbl_schedule d on c.id_schedule=d.id
ORDER BY a.id ASC");
	$no=1;
	$n=1;
	$c=0;
	 ?>
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
  <a href="?p=Form-Masalah-Celup" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
     </div>
      <div class="box-body">
        <table id="example1" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
              <th width="52"><div align="center"><font size="-1">Nokk</font></div></th>
			  <th width="52"><div align="center"><font size="-1">Mesin</font></div></th>
			  <th width="115"><div align="center"><font size="-1">Shift</font></div></th>
              <th width="115"><div align="center"><font size="-1">Buyer</font></div></th>
              <th width="112"><div align="center"><font size="-1">Order</font></div></th>
              <th width="204"><div align="center"><font size="-1">Warna</font></div></th>
              <th width="144"><div align="center"><font size="-1">Proses</font></div></th>
              <th width="144"><div align="center"><font size="-1">Inspektor</font></div></th>
              <th width="144"><div align="center"><font size="-1">Masalah</font></div></th>
              <th width="144"><div align="center"><font size="-1">Tidakan Perbaikan</font></div></th>
            </tr>
          </thead>
          <tbody>
            <?php
	function cekDesimal($angka){
	$bulat=round($angka);
	if($bulat>$angka){
		$jam=$bulat-1;
		$waktu=$jam.":30";
	}else{
		$jam=$bulat;
		$waktu=$jam.":00";
	}
	return $waktu;
}
	  $col=0;
  while($rowd=mysqli_fetch_array($data)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  		$qCek=mysqli_query($con,"SELECT id as idb FROM tbl_potongcelup WHERE nokk='$rowd[nokk]' ORDER BY id DESC LIMIT 1");
	  	    $rCEk=mysqli_fetch_array($qCek);
		 ?>
       <tr bgcolor="<?php echo $bgcolor; ?>">
         <td align="center"><font size="-1"><?php echo $rowd['nokk'];?></font></td>
              <td align="center"><font size="-1"><?php echo $rowd['no_mesin'];?></font></td>
              <td align="center"><font size="-1"><?php echo $rowd['shift'].$rowd['g_shift'];?></font></td>
              <td align="center"><font size="-2"><?php echo $rowd['buyer'];?></font></td>
              <td align="center"><font size="-1"><?php echo $rowd['no_order'];?></font></td>
              <td><font size="-2"><?php echo $rowd['warna'];?></font></td>
              <td align="left"><font size="-1"><?php echo $rowd['proses'];?></font><br><i class="btn btn-xs bg-hijau"><font size="-2"><?php echo $rowd['operator_keluar'];?></font></i></td>
              <td align="center"><font size="-1"><?php echo $rowd['inspektor'];?></font></td>
              <td align="left"><font size="-1"><?php echo $rowd['masalah'];?></font></td>
              <td align="left"><font size="-1"><?php echo $rowd['tidakan_perbaikan'];?></font></td>
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
<div id="PotongEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="ShiftEdit1" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>	
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