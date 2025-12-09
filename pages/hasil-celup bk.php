<?PHP
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
   $data=mysql_query("SELECT
	a.*,
	b.buyer,
	b.no_order,
	b.no_mesin,
	b.warna,
	b.proses,
	b.target,
	c.id as ids,
	b.id as idm
FROM
	tbl_hasilcelup a
	LEFT JOIN tbl_montemp c ON a.id_montemp=c.id
	LEFT JOIN tbl_schedule b ON c.id_schedule = b.id
WHERE
	DATE_FORMAT( a.tgl_buat, '%Y-%m-%d' ) = DATE_FORMAT( now( ), '%Y-%m-%d' ) 
ORDER BY
	a.id ASC");
	$no=1;
	$n=1;
	$c=0;
	 ?>
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
  <a href="?p=Form-Celup" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
  <!--<a href="pages/cetak/reports-cetak.php" class="btn btn-danger pull-right" target="_blank"><i class="fa fa-print"></i> Cetak</a> -->	
      </div>
      <div class="box-body">
        <table id="example1" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th width="52"><div align="center">Mesin</div></th>
              <th width="115"><div align="center">Buyer</div></th>
              <th width="112"><div align="center">Order</div></th>
              <th width="204"><div align="center">Warna</div></th>
              <th width="144"><div align="center">Proses</div></th>
              <th width="85"><div align="center">Target</div></th>
              <th width="85"><div align="center">Lama Proses</div></th>
              <th width="237"><div align="center">Keterangan</div></th>
              <th width="70"><div align="center">Action</div></th>
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
  while($rowd=mysql_fetch_array($data)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  		$qCek=mysql_query("SELECT id as idb FROM tbl_potongcelup WHERE nokk='$rowd[nokk]' LIMIT 1");
	  	    $rCEk=mysql_fetch_array($qCek);
		 ?>
            <tr bgcolor="<?php echo $bgcolor; ?>">
              <td align="center"><?php echo $rowd['no_mesin'];?></td>
              <td align="center"><?php echo $rowd['buyer'];?></td>
              <td align="center"><?php echo $rowd['no_order'];?></td>
              <td><?php echo $rowd['warna'];?></td>
              <td align="left"><?php echo $rowd['proses'];?><br><i class="btn btn-xs bg-hijau"><?php echo $rowd['operator_keluar'];?></i></td>
              <td align="center"><?php echo cekDesimal($rowd['target']);?></td>
              <td align="center"><?php echo $rowd['lama_proses'];?></td>
              <td><i class="label bg-abu"><?php echo $rowd['nokk'];?></i><br><?php echo $rowd['ket'];?><br><i class="btn btn-xs <?php if($rowd['status']=="OK"){echo "bg-green";}else if($rowd['status']=="Gagal Proses"){echo "bg-red";}else if($rowd['status']=="Levelling-Matching"){echo "bg-primary";}else if($rowd['status']=="Pelunturan-Matching"){echo "bg-info";} ?>"><?php echo $rowd['status'];?></i></td>
              <td align="center"><div class="btn-group"><a href="pages/cetak/cetak_celup.php?id=<?php echo $rCEk[idb] ?>" class="btn btn-xs btn-warning" target="_blank"><i class="fa fa-print"></i> </a><a href="#" id='<?php echo $rCEk['idb']; ?>' class="btn btn-xs btn-info potong_edit"><i class="fa fa-edit"></i> </a><a href="#" onclick="confirm_del('?p=clp_hapus&id=<?php echo $rowd[id] ?>');" class="btn btn-xs btn-danger <?php if($_SESSION['lvl_id10']=="3" or $rCEk['idb']!=""){echo "disabled"; } ?>"><i class="fa fa-trash"></i> </a></div></td>
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