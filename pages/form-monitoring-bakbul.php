<?php
  include "koneksiLAB.php";
  include "koneksi.php";
  $nokk=$_GET['nokk'];
  $sqlCek=mysqli_query($con,"SELECT * FROM tbl_schedule WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
  $cek=mysqli_num_rows($sqlCek);
  $rcek=mysqli_fetch_array($sqlCek);
  $monCek1=mysqli_query($con,"SELECT * FROM tbl_montemp WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
  $mcek1=mysqli_num_rows($monCek1);
  $rmcek1=mysqli_fetch_array($monCek1);
  $sqlCek1=mysqli_query($con,"SELECT * FROM tbl_bakbul WHERE no_kk='$nokk' ORDER BY rec_datecreated DESC LIMIT 1");
  $cek1=mysqli_num_rows($sqlCek1);
  $rcek1=mysqli_fetch_array($sqlCek1);
  $sqlcek2=mysqli_query($con,"SELECT
   	id,
	  if(COUNT(lot)>1,'Gabung Kartu','') as ket_kartu,
	  if(COUNT(lot)>1,CONCAT('(',COUNT(lot),'kk',')'),'') as kk,
	  GROUP_CONCAT(nokk SEPARATOR ', ') as g_kk,
	  no_mesin,
	  no_urut,	
	  sum(rol) as rol,
	  sum(bruto) as bruto
  FROM
	  tbl_schedule 
  WHERE
	  (status='antri mesin' or status='sedang jalan') and no_mesin='".$rcek['no_mesin']."'  and no_urut='".$rcek['no_urut']."'
  GROUP BY
	  no_mesin,
	  no_urut 
  ORDER BY
	  id ASC");
  $cek2=mysqli_num_rows($sqlcek2);
  $rcek2=mysqli_fetch_array($sqlcek2);
  if($rcek2['ket_kartu']!=""){$ketsts=$rcek2['ket_kartu']."\n(".$rcek2['g_kk'].")";}else{$ketsts="";}
?>
<?php
  if ($countdata > 0)
  {date_default_timezone_set('Asia/Jakarta');
    do{ $i++; }while($ai>=$i);
    $jb1=$ar[0];
    $jb2=$ar[1];
    $jb3=$ar[2];
    $jb4=$ar[3];
    if($ai<2){$jb1=$ar[0];
      $jb2='';
      $jb3='';
    }
    $bng=$jb1.",".$jb2.",".$jb3.",".$jb4;
  }
  if($nokk!="" and $rcek2['bruto']!="" and $rcek2['bruto']>0 ){
    $lr=round($row['VOLUME']/$rcek2['bruto']);
  }else{$lr="";}
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
?>
<?php
  $Kapasitas	= isset($_POST['kapasitas']) ? $_POST['kapasitas'] : '';
  $TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
  $Item		= isset($_POST['item']) ? $_POST['item'] : '';
  $Warna		= isset($_POST['warna']) ? $_POST['warna'] : '';
  $Langganan	= isset($_POST['langganan']) ? $_POST['langganan'] : '';
?>
<form class="form-horizontal" method="post" enctype="multipart/form-data">
  <div class="box box-info">
  	<div class="box-header with-border">
      <h3 class="box-title">Input Data Kartu Kerja</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
 	  <div class="box-body"> 
	    <div class="col-md-6">
		    <div class="form-group">
          <label for="no_po" class="col-sm-3 control-label">No KK</label>
          <div class="col-sm-4">
				    <input name="no_kk" type="text" class="form-control" id="no_kk" 
              onchange="window.location='?p=Form-Monitoring-BakBul&nokk='+this.value" value="<?php echo $_GET['nokk'];?>" placeholder="No KK" required >
		      </div>
        </div>		
		    <div class="form-group">
			    <label for="l_g" class="col-sm-3 control-label">L X Grm Permintaan</label>
			    <div class="col-sm-2">
				    <input name="lebar" type="text" class="form-control" id="lebar" 
				      value="<?php if($cek>0){echo $rcek['lebar'];}else{echo round($r['Lebar']);} ?>" placeholder="0" required>
			    </div>
			    <div class="col-sm-2">
				    <input name="grms" type="text" class="form-control" id="grms" 
				    value="<?php if($cek>0){echo $rcek['gramasi'];}else{echo round($r['Gramasi']);} ?>" placeholder="0" required>
			    </div>		
		    </div>		
		    <div class="form-group">
          <label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
          <div class="col-sm-3">
					  <div class="input-group">  
              <input name="qty1" type="text" class="form-control" id="qty1" 
                value="<?php if($cek>0){echo $rcek['qty_order'];}else{echo round($r['BatchQuantity'],2);} ?>" placeholder="0.00" required>
					    <span class="input-group-addon">KGs</span>
            </div>  
          </div>
				  <div class="col-sm-4">
					  <div class="input-group">  
              <input name="qty2" type="text" class="form-control" id="qty2" 
                value="<?php if($cek>0){echo $rcek['pjng_order'];}else{echo round($r['Quantity'],2);} ?>" placeholder="0.00" style="text-align: right;" required>
              <span class="input-group-addon">
						    <select name="satuan1" style="font-size: 12px;">
							    <option value="Yard" <?php if($rcek['satuan_order']=="Yard"){ echo "SELECTED"; }?>>Yard</option>
							    <option value="Meter" <?php if($rcek['satuan_order']=="Meter"){ echo "SELECTED"; }?>>Meter</option>
							    <option value="PCS" <?php if($rcek['satuan_order']=="PCS"){ echo "SELECTED"; }?>>PCS</option>
						    </select>
				      </span>
					  </div>	
          </div>		
        </div>
		    <div class="form-group">
          <label for="lot" class="col-sm-3 control-label">Lot</label>
          <div class="col-sm-2">
            <input name="lot" type="text" class="form-control" id="lot" 
              value="<?php if($cek>0){echo $rcek['lot'];}else{if($nomorLot!=""){echo $lotno;}else if($nokk!=""){echo $cekM['lot'];} } ?>" placeholder="Lot" >
           </div>				   
        </div>
		    <div class="form-group">
			    <label for="jml_bruto" class="col-sm-3 control-label">Rol &amp; Qty</label>
			    <div class="col-sm-2">
				    <input name="qty3" type="text" class="form-control" id="qty3" 
				      value="<?php if($cek2>0){echo $rcek2['rol'].$rcek2['kk'];} ?>" placeholder="0.00" required>
			    </div>
			    <div class="col-sm-3">
				    <div class="input-group">  
				      <input name="qty4" type="text" class="form-control" id="qty4" 
				        value="<?php if($cek2>0){echo $rcek2['bruto'];} ?>" placeholder="0.00" style="text-align: right;" required>
				      <span class="input-group-addon">KGs</span>
				    </div>	
			    </div>		
		    </div>
		    <div class="form-group">
		      <label for="benang" class="col-sm-3 control-label">Benang</label>                  
			    <div class="col-sm-8">
            <input name="benang" type="text" class="form-control" id="benang" value="<?php echo $bng; ?>" placeholder="Benang" >
          </div>				   
        </div>
		    <div class="form-group">
          <label for="std_cok_wrn" class="col-sm-3 control-label">Standar Cocok Warna</label>                  
          <div class="col-sm-6">
            <input name="std_cok_wrn" type="text" class="form-control" id="std_cok_wrn"value="<?php if($cek>0){echo $rmcek1['std_cok_wrn'];} ?>" placeholder="Standar Cocok Warna" >
          </div>				   
        </div> 	  
		    <div class="form-group">
          <label for="shift" class="col-sm-3 control-label">Shift</label>
          <div class="col-sm-2">					  
						<select id="shift" name="shift" class="form-control" required>
							<option value="">Pilih</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
					  </select>
				  </div>
          <label for="KodeWarna" class="col-sm-2 control-label">Kode Warna</label>
          <div class="col-sm-3">
				    <input name="colCode" type="text" class="form-control" id="colCode" 
				    value="<?php if($cek>0){echo $rcek['kategori_warna'];}else{echo round($r['kategori_warna']);} ?>" placeholder="0" required>
			    </div>
        </div>
        <div class="form-group">
          <label for="g_shift" class="col-sm-3 control-label">Group Shift</label>
          <div class="col-sm-2">
            <select id="g_shift" name="g_shift" class="form-control" required>
              <option value="">Pilih</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
					  </select>
          </div>
        </div>
        <div class="form-group">
          <label for="operator" class="col-sm-3 control-label">Operator </label>
          <div class="col-sm-5">
            <select id="operator" name="operator" class="form-control" required>
              <option value="">Pilih</option>
                <?php 
							    $sqlKap=mysqli_query($con,"SELECT nama FROM tbl_staff WHERE jabatan='Operator' ORDER BY nama ASC");
							    while($rK=mysqli_fetch_array($sqlKap)){
							  ?>
							<option value="<?php echo $rK['nama']; ?>"><?php echo $rK['nama']; ?></option>
							 <?php } ?>	  
					  </select>
				  </div>
        </div>
		    <div class="form-group">
          <label for="leader" class="col-sm-3 control-label">Leader </label>
          <div class="col-sm-5">
            <select id="leader" name="leader" class="form-control" required>
              <option value="">Pilih</option>
							  <?php 
							    $sqlKap=mysqli_query($con,"SELECT nama FROM tbl_staff WHERE jabatan='Leader' ORDER BY nama ASC");
							    while($rK=mysqli_fetch_array($sqlKap)){
							  ?>
							<option value="<?php echo $rK['nama']; ?>"><?php echo $rK['nama']; ?></option>
							 <?php } ?>	  
					  </select>
				  </div>
	      </div>			  
	    </div>
	  	
	  	<!-- col --> 
	    <div class="col-md-6">
        <div class="form-group">
          <label for="speed" class="col-sm-3 control-label">Speed</label>
          <div class="col-sm-3">
            <div class="input-group">
              <input name="speed" type="text" style="text-align: right;" class="form-control" id="speed" value="" placeholder="0.00" >
              <span class="input-group-addon">m/mnt</span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="sc1" class="col-sm-3 control-label">Singeing - 1</label>
          <div class="col-sm-3">
            <input name="singeing1" type="text" class="form-control" id="singeing1" placeholder="0.00">
          </div>
          <label for="sc1" class="col-sm-1 control-label">Presure</label>
          <div class="col-sm-3">
            <input name="presure1" type="text" class="form-control" id="presure1" placeholder="0.00">
          </div>
        </div>
        <div class="form-group">
          <label for="sc1" class="col-sm-3 control-label">Singeing - 2</label>
          <div class="col-sm-3">
            <input name="singeing2" type="text" class="form-control" id="singeing2" placeholder="0.00">
          </div>
          <label for="sc1" class="col-sm-1 control-label">Presure</label>
          <div class="col-sm-3">
            <input name="presure2" type="text" class="form-control" id="presure2" placeholder="0.00">
          </div>
        </div>
        <div class="form-group">
          <label for="singeing_type" class="col-sm-3 control-label">Singeing</label>
          <div class="col-sm-3">					  
						<select id="singeing_type" name="singeing_type" class="form-control" required>
							<option value="">Pilih</option>
							<option value="Vertical Singeing">Vertical Singeing</option>
							<option value="Tilted Singeing">Tilted Singeing</option>
					  </select>
				  </div>
        </div>
        <div class="form-group">
          <label for="proses" class="col-sm-3 control-label">Proses</label>
          <div class="col-sm-3">					  
						<select id="proses" name="proses" class="form-control" required>
							<option value="">Pilih</option>
							<option value="Greige">Greige</option>
							<option value="Perbaikan">Perbaikan</option>
					  </select>
				  </div>
        </div>
      </div>
    </div>
  </div>
  <div class="box-footer">
    <button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Monitoring-Tempelan'">Kembali <i class="fa fa-arrow-circle-o-left"></i></button>
    <?php if($cek1>0){ 
    	echo "<script>swal({
      title: 'No Kartu Sudah diinput dan belum selesai proses',
      text: 'Klik Ok untuk input kembali',
      type: 'warning',
      }).then((result) => {
      if (result.value) {
        window.location='index1.php?p=Form-Monitoring-BakBul';
      }
    });</script>";	
       } else if($rcek['no_urut']!="1" and $nokk!=""){
    	echo "<script>swal({
      title: 'Harus No Urut `1` ',
      text: 'Klik Ok untuk input kembali',
      type: 'warning',
      }).then((result) => {
      if (result.value) {
        window.location='index1.php?p=Form-Monitoring-BakBul';
      }
    });</script>"; }else{ ?>	   
   <button id="btnSave" type="submit" name="save" value="save" class="btn btn-primary pull-right">Simpan <i class="fa fa-save"></i></button>
   <?php } ?>
  </div>
</form>

<?php
  // if($_POST['save']=="save"){
  //   $rec_usercreated = $_SESSION['user_id10'];
  //   $no_kk = mysqli_real_escape_string($con, $_POST['no_kk']);
  //   $gmrs = mysqli_real_escape_string($con, $_POST['grms']);
  //   $qty_order = mysqli_real_escape_string($con, $_POST['qty1']);
  //   $lot = mysqli_real_escape_string($con, $_POST['lot']);
  //   $rol = mysqli_real_escape_string($con, $_POST['qty3']);
  //   $qty_rol = mysqli_real_escape_string($con, $_POST['qty_rol']);
  //   $benang = mysqli_real_escape_string($con, $_POST['benang']);
  //   $standar_cok_col = mysqli_real_escape_string($con, $_POST['std_cok_wrn']);
  //   $shift = mysqli_real_escape_string($con, $_POST['shift']);
  //   $g_shift = mysqli_real_escape_string($con, $_POST['g_shift']);
  //   $color_code = mysqli_real_escape_string($con, $_POST['colCode']);
  //   $operator = mysqli_real_escape_string($con, $_POST['operator']);
  //   $leader = mysqli_real_escape_string($con, $_POST['leader']);
  //   $speed = mysqli_real_escape_string($con, $_POST['speed']);
  //   $singeing1 = mysqli_real_escape_string($con, $_POST['singeing1']);
  //   $presure1 = mysqli_real_escape_string($con, $_POST['presure1']);
  //   $singeing2 = mysqli_real_escape_string($con, $_POST['singeing2']);
  //   $presure2 = mysqli_real_escape_string($con, $_POST['presure2']);
  //   $singeing_type = mysqli_real_escape_string($con, $_POST['singeing_type']);
  //   $proses = mysqli_real_escape_string($con, $_POST['proses']);

  //   $sqlData = mysqli_query($con,"INSERT INTO tbl_bakbul SET
  //     rec_usercreated = '$rec_usercreated',
  //     rec_userupdate = '$rec_usercreated',
  //     rec_datecreated = now(),
  //     rec_dateupdate = now(),
  //     rec_status = '1',
  //     no_kk = '$no_kk',
  // 		gmrs = '$gmrs',
  // 		qty_order = '$qty_order',
  // 		lot = '$lot',
  // 		rol = '$rol',
  // 		qty_rol = '$qty_rol',
  // 		benang = '$benang',
  // 		standar_cok_col='$standar_cok_col',
  // 		shift = '$shift',
  // 		g_shift = '$g_shift',
  // 		color_code = '$color_code',
  // 		operator = '$operator',
  // 		leader = '$leader',
  // 		speed = '$speed',
  // 		singeing1 = '$singeing1',
  // 		presure1 = '$presure1',
  // 		singeing2 = '$singeing2',
  // 		presure2 = '$presure2',
  // 		singeing_type = '$singeing_type',
  // 		proses = '$proses'"); 	  
  
  //   if($sqlData){
  //     $sqlData2 = mysqli_query($con,"INSERT INTO tbl_montemp SET
  //       id_schedule='$rcek[id]',
	// 	    nokk='$no_kk',
  //       nodemand='$rcek[nodemand]',
	// 	    operator='$operator',
	// 	    leader='$leader',
	// 	    shift='$shift',
	// 	    gramasi_a='$gmrs',
	// 	    rol='$rol',
	// 	    g_shift='$g_shift',
	// 	    benang='$benang',
	// 	    std_cok_wrn='$standar_cok_col',
	// 	    speed='$speed',
	// 	    tgl_buat=now(),
	// 	    tgl_target=ADDDATE(now(), INTERVAL '$_POST[target]' HOUR_MINUTE),
	// 	    tgl_update=now()
  //     ");
  //     if($sqlData2){
  //       $sqlD=mysqli_query($con,"UPDATE tbl_schedule SET 
	// 	    status='sedang jalan',
	// 	    tgl_update=now()
	// 	    WHERE status='antri mesin' and no_mesin='".$rcek['no_mesin']."' and no_urut='1' ");

  //       echo "<script>swal({
  //         title: 'Data Tersimpan',   
  //         text: 'Klik Ok untuk input data kembali',
  //         type: 'success',
  //         }).then((result) => {
  //         if (result.value) {
  //           window.location.href='?p=Monitoring-Tempelan'; 
  //         }
  //       });</script>";
  //     }else{
  //       echo "<script>swal({
  //         title: 'Data Gagal Tersimpan',   
  //         text: 'Klik Ok untuk input data kembali',
  //         type: 'warning',
  //         }).then((result) => {
  //         if (result.value) {
  //           window.location.href='?p=Monitoring-Tempelan'; 
  //         }
  //       });</script>";
  //     }
  //   }
  // }
?>

<?php
  if($_POST['save']=="save"){
    $rec_usercreated = $_SESSION['user_id10'];
    $no_kk = mysqli_real_escape_string($con, $_POST['no_kk']);
    $gmrs = mysqli_real_escape_string($con, $_POST['grms']);
    $qty_order = mysqli_real_escape_string($con, $_POST['qty1']);
    $lot = mysqli_real_escape_string($con, $_POST['lot']);
    $rol = mysqli_real_escape_string($con, $_POST['qty3']);
    $qty_rol = mysqli_real_escape_string($con, $_POST['qty_rol']);
    $benang = mysqli_real_escape_string($con, $_POST['benang']);
    $standar_cok_col = mysqli_real_escape_string($con, $_POST['std_cok_wrn']);
    $shift = mysqli_real_escape_string($con, $_POST['shift']);
    $g_shift = mysqli_real_escape_string($con, $_POST['g_shift']);
    $color_code = mysqli_real_escape_string($con, $_POST['colCode']);
    $operator = mysqli_real_escape_string($con, $_POST['operator']);
    $leader = mysqli_real_escape_string($con, $_POST['leader']);
    $speed = mysqli_real_escape_string($con, $_POST['speed']);
    $singeing1 = mysqli_real_escape_string($con, $_POST['singeing1']);
    $presure1 = mysqli_real_escape_string($con, $_POST['presure1']);
    $singeing2 = mysqli_real_escape_string($con, $_POST['singeing2']);
    $presure2 = mysqli_real_escape_string($con, $_POST['presure2']);
    $singeing_type = mysqli_real_escape_string($con, $_POST['singeing_type']);
    $proses = mysqli_real_escape_string($con, $_POST['proses']);

    mysqli_autocommit($con, false);
    try{
      // Query 1: Insert ke tbl_bakbul
      $sqlData = mysqli_query($con,"INSERT INTO tbl_bakbul SET
        rec_usercreated = '$rec_usercreated',
        rec_userupdate = '$rec_usercreated',
        rec_datecreated = now(),
        rec_dateupdate = now(),
        rec_status = '1',
        no_kk = '$no_kk',
        gmrs = '$gmrs',
        qty_order = '$qty_order',
        lot = '$lot',
        rol = '$rol',
        qty_rol = '$qty_rol',
        benang = '$benang',
        standar_cok_col='$standar_cok_col',
        shift = '$shift',
        g_shift = '$g_shift',
        color_code = '$color_code',
        operator = '$operator',
        leader = '$leader',
        speed = '$speed',
        singeing1 = '$singeing1',
        presure1 = '$presure1',
        singeing2 = '$singeing2',
        presure2 = '$presure2',
        singeing_type = '$singeing_type',
        proses = '$proses'"
      );
      if (!$sqlData) {
        throw new Exception("Gagal insert ke tbl_bakbul");
      }

      // Query 2: Insert ke tbl_montemp
      $sqlData2 = mysqli_query($con,"INSERT INTO tbl_montemp SET
        id_schedule='$rcek[id]',
        nokk='$no_kk',
        nodemand='$rcek[nodemand]',
        operator='$operator',
        leader='$leader',
        shift='$shift',
        gramasi_a='$gmrs',
        rol='$rol',
        g_shift='$g_shift',
        benang='$benang',
        std_cok_wrn='$standar_cok_col',
        speed='$speed',
        bruto='$qty_order',
        jammasukkain=now(),
        tgl_buat=now(),
        tgl_target=ADDDATE(now(), INTERVAL '$_POST[target]' HOUR_MINUTE),
        tgl_update=now()
      ");
      if (!$sqlData2) {
        throw new Exception("Gagal insert ke tbl_montemp: " . mysqli_error($con));
      }
      mysqli_commit($con);
      // Query 3: Update tbl_schedule
      $sqlD = mysqli_query($con,"UPDATE tbl_schedule SET 
        status='sedang jalan',
        tgl_update=now()
        WHERE status='antri mesin' AND no_mesin='".$rcek['no_mesin']."' AND no_urut='1'"
      );
      if (!$sqlD) {
        throw new Exception("Gagal update tbl_schedule");
      }

      echo "<script>swal({
        title: 'Data Tersimpan',   
        text: 'Klik Ok untuk input data kembali',
        type: 'success',
      }).then((result) => {
        if (result.value) {
          window.location.href='?p=Monitoring-Tempelan'; 
        }
      });</script>";
    } catch (Exception $e) {
      mysqli_rollback($con);

      echo "<script>swal({
        title: 'Gagal Menyimpan Data',   
        text: 'Kesalahan: " . addslashes($e->getMessage()) . "',
        type: 'error',
      }).then((result) => {
        if (result.value) {
          window.location.href='?p=Monitoring-Tempelan'; 
        }
      });</script>";
    }
  }
  mysqli_autocommit($con, true);
?>