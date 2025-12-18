<?php
  include "koneksiLAB.php";
  include "koneksi.php";
  session_start();
  $nokk=$_GET['nokk'];
  $query_cek = "SELECT TOP 1
          COUNT(*) OVER() as total_rows, 
            * 
          FROM db_dying.tbl_schedule 
          WHERE 
            nokk='$nokk' 
          ORDER BY 
            id DESC 
          ";
  $sqlCek	=sqlsrv_query($con,$query_cek);
  $rcek	=sqlsrv_fetch_array($sqlCek);
  $cek	=$rcek['total_rows'];
  $query_cek1 = "SELECT TOP 1 
            COUNT(*) OVER() as total_rows, 
            * 
          FROM 
            db_dying.tbl_montemp 
          WHERE 
            nokk='$nokk' 
            and (status='antri mesin' or status='sedang jalan' or status='selesai') 
          ORDER BY id DESC";
  $sqlCek1=	sqlsrv_query($con,$query_cek1);
  $rcek1	=	sqlsrv_fetch_array($sqlCek1);
  $cek1	=	$rcek1['total_rows'];
  $query_cek2 = "SELECT
            COUNT(*) OVER() as total_rows,
            MAX(id) as id,
            CASE
              WHEN COUNT(lot)>1 THEN 'Gabung Kartu'
              ELSE ''
            END AS ket_kartu,
            CASE 
              WHEN COUNT(lot) > 1 
              THEN CONCAT('(', CAST(COUNT(lot) AS VARCHAR), 'kk', ')') 
              ELSE '' 
            END AS kk,
            STRING_AGG(nokk, ', ') AS g_kk,
            no_mesin,
            no_urut,
            sum(rol) as rol,
            sum(bruto) as bruto
          FROM
            db_dying.tbl_schedule
          WHERE
            NOT status = 'selesai'
            and no_mesin='".$rcek['no_mesin']."'
            and no_urut= '".$rcek['no_urut']."'
          GROUP BY
            no_mesin,
            no_urut
          ORDER BY
            id ASC";
  // echo $query_cek2;
  $sqlcek2 = sqlsrv_query($con,$query_cek2);
  $rcek2	 = sqlsrv_fetch_array($sqlcek2);
  $cek2	 = $rcek2['total_rows'];
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
							    $sqlKap=sqlsrv_query($con,"SELECT nama FROM db_dying.tbl_staff WHERE jabatan='Operator' ORDER BY nama ASC");
							    while($rK=sqlsrv_fetch_array($sqlKap)){
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
							    $sqlKap=sqlsrv_query($con,"SELECT nama FROM db_dying.tbl_staff WHERE jabatan='Leader' ORDER BY nama ASC");
							    while($rK=sqlsrv_fetch_array($sqlKap)){
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
  //   $no_kk = sqlsrv_real_escape_string($con, $_POST['no_kk']);
  //   $gmrs = sqlsrv_real_escape_string($con, $_POST['grms']);
  //   $qty_order = sqlsrv_real_escape_string($con, $_POST['qty1']);
  //   $lot = sqlsrv_real_escape_string($con, $_POST['lot']);
  //   $rol = sqlsrv_real_escape_string($con, $_POST['qty3']);
  //   $qty_rol = sqlsrv_real_escape_string($con, $_POST['qty_rol']);
  //   $benang = sqlsrv_real_escape_string($con, $_POST['benang']);
  //   $standar_cok_col = sqlsrv_real_escape_string($con, $_POST['std_cok_wrn']);
  //   $shift = sqlsrv_real_escape_string($con, $_POST['shift']);
  //   $g_shift = sqlsrv_real_escape_string($con, $_POST['g_shift']);
  //   $color_code = sqlsrv_real_escape_string($con, $_POST['colCode']);
  //   $operator = sqlsrv_real_escape_string($con, $_POST['operator']);
  //   $leader = sqlsrv_real_escape_string($con, $_POST['leader']);
  //   $speed = sqlsrv_real_escape_string($con, $_POST['speed']);
  //   $singeing1 = sqlsrv_real_escape_string($con, $_POST['singeing1']);
  //   $presure1 = sqlsrv_real_escape_string($con, $_POST['presure1']);
  //   $singeing2 = sqlsrv_real_escape_string($con, $_POST['singeing2']);
  //   $presure2 = sqlsrv_real_escape_string($con, $_POST['presure2']);
  //   $singeing_type = sqlsrv_real_escape_string($con, $_POST['singeing_type']);
  //   $proses = sqlsrv_real_escape_string($con, $_POST['proses']);

  //   $sqlData = sqlsrv_query($con,"INSERT INTO tbl_bakbul SET
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
  //     $sqlData2 = sqlsrv_query($con,"INSERT INTO tbl_montemp SET
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
  //       $sqlD=sqlsrv_query($con,"UPDATE tbl_schedule SET 
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
    function clean($data, $is_int = false) {
        $val = isset($data) ? trim($data) : '';
        if ($val === '') return null; 
        return $is_int ? (int)$val : $val;
    }
    // $rec_usercreated = $_SESSION['user_id10'];
    // $no_kk = sqlsrv_real_escape_string($con, $_POST['no_kk']);
    // $gmrs = sqlsrv_real_escape_string($con, $_POST['grms']);
    // $qty_order = sqlsrv_real_escape_string($con, $_POST['qty1']);
    // $lot = sqlsrv_real_escape_string($con, $_POST['lot']);
    // $rol = sqlsrv_real_escape_string($con, $_POST['qty3']);
    // $qty_rol = sqlsrv_real_escape_string($con, $_POST['qty_rol']);
    // $benang = sqlsrv_real_escape_string($con, $_POST['benang']);
    // $standar_cok_col = sqlsrv_real_escape_string($con, $_POST['std_cok_wrn']);
    // $shift = sqlsrv_real_escape_string($con, $_POST['shift']);
    // $g_shift = sqlsrv_real_escape_string($con, $_POST['g_shift']);
    // $color_code = sqlsrv_real_escape_string($con, $_POST['colCode']);
    // $operator = sqlsrv_real_escape_string($con, $_POST['operator']);
    // $leader = sqlsrv_real_escape_string($con, $_POST['leader']);
    // $speed = sqlsrv_real_escape_string($con, $_POST['speed']);
    // $singeing1 = sqlsrv_real_escape_string($con, $_POST['singeing1']);
    // $presure1 = sqlsrv_real_escape_string($con, $_POST['presure1']);
    // $singeing2 = sqlsrv_real_escape_string($con, $_POST['singeing2']);
    // $presure2 = sqlsrv_real_escape_string($con, $_POST['presure2']);
    // $singeing_type = sqlsrv_real_escape_string($con, $_POST['singeing_type']);
    // $proses = sqlsrv_real_escape_string($con, $_POST['proses']);

    $status         = 1; // Default status

    // Variabel dari $_POST
    $no_kk           = clean($_POST['no_kk']);
    $gmrs            = clean($_POST['grms']);
    $qty_order       = clean($_POST['qty1'], true); // Kolom INT
    $lot             = clean($_POST['lot']);
    $rol             = clean($_POST['qty3']);
    $qty_rol         = clean($_POST['qty_rol'], true); // Kolom INT
    $benang          = clean($_POST['benang']);
    $standar_cok_col = clean($_POST['std_cok_wrn']);
    $shift           = clean($_POST['shift']);
    $g_shift         = clean($_POST['g_shift']);
    $color_code      = clean($_POST['colCode']);
    $operator        = clean($_POST['operator']);
    $leader          = clean($_POST['leader']);
    $speed           = clean($_POST['speed']);
    $singeing1       = clean($_POST['singeing1']);
    $presure1        = clean($_POST['presure1']);
    $singeing2       = clean($_POST['singeing2']);
    $presure2        = clean($_POST['presure2']);
    $singeing_type   = clean($_POST['singeing_type']);
    $proses          = clean($_POST['proses']);
    $target_menit    = is_numeric($_POST['target']) ? $_POST['target'] : 0;  
      // Query 1: Insert ke tbl_bakbul
    
      // if (!$sqlData) {
      //   throw new Exception("Gagal insert ke tbl_bakbul");
      // }

      // Query 2: Insert ke tbl_montemp
      $query_montemp = "INSERT INTO db_dying.tbl_montemp(
                        id_schedule, nokk, nodemand, operator, leader, 
                        shift, gramasi_a, rol, g_shift, benang, std_cok_wrn, speed, bruto, 
                        jammasukkain, tgl_buat, tgl_target, tgl_update)
                        VALUES(
                                ?,?,?,?,?,?,?,?,?,?,?,?,?,GETDATE(),GETDATE(),DATEADD(MINUTE, CAST(? AS INT), GETDATE()),GETDATE()
                        )";
            
      $params2 = [
                      $rcek['id'],        
                      $no_kk,             
                      $rcek['nodemand'],  
                      $operator,          
                      $leader,            
                      $shift,             
                      $gmrs,              
                      $rol,               
                      $g_shift,           
                      $benang,            
                      $standar_cok_col,   
                      $speed,             
                      $qty_order,         
                      $target_menit_val   
                  ];
      $sqlData2 = sqlsrv_query($con,$query_montemp, $params2);
      // $sqlData2 = sqlsrv_query($con,"INSERT INTO db_dying.tbl_montemp SET
      //   id_schedule=
      //   nokk=
      //   nodemand=
      //   operator=
      //   leader=
      //   shift=
      //   gramasi_a=
      //   rol=
      //   g_shift=
      //   benang=
      //   std_cok_wrn=
      //   speed=
      //   bruto=
      //   jammasukkain=
      //   tgl_buat=
      //   tgl_target=
      //   tgl_update=
      // ");
       
      // if (!$sqlData2) {
      //   throw new Exception("Gagal insert ke tbl_montemp: " . sqlsrv_error($con));
      // }
      // sqlsrv_commit($con);

      if($sqlData2){
        $query = "INSERT INTO db_dying.tbl_bakbul (
            rec_usercreated, 
            rec_userupdate, 
            rec_datecreated, 
            rec_dateupdate, 
            rec_status,
            no_kk, 
            gmrs, 
            qty_order, 
            lot, 
            rol, 
            qty_rol, 
            benang,
            standar_cok_col, 
            shift, 
            g_shift, 
            color_code, 
            operator, 
            leader, 
            speed, 
            singeing1, 
            presure1, 
            singeing2, 
            presure2, 
            singeing_type, 
            proses
        ) VALUES (
            ?, ?, GETDATE(), GETDATE(), '1',
            ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?
        )";

        $params = [
            $rec_usercreated,
            $rec_usercreated, // untuk rec_userupdate
            $no_kk,
            $gmrs,
            $qty_order,
            $lot,
            $rol,
            $qty_rol,
            $benang,
            $standar_cok_col,
            $shift,
            $g_shift,
            $color_code,
            $operator,
            $leader,
            $speed,
            $singeing1,
            $presure1,
            $singeing2,
            $presure2,
            $singeing_type,
            $proses
          ];

      $sqlData = sqlsrv_query($con, $query, $params);
			/*$sqlD=sqlsrv_query("UPDATE tbl_schedule SET 
		  status='sedang jalan',
		  tgl_update=now()
		  WHERE id='$_POST[id]'");*/
        $sqlD=sqlsrv_query($con,"UPDATE db_dying.tbl_schedule SET 
                      status='sedang jalan',
                      tgl_update=GETDATE()
                      WHERE 
                      status='antri mesin' 
                      and no_mesin='".$rcek['no_mesin']."' 
                      and no_urut='1' ");
        echo "<script>swal({
          title: 'Data Tersimpan',   
          text: 'Klik Ok untuk input data kembali',
          type: 'success',
          }).then((result) => {
          if (result.value) {
            
            window.location.href='?p=Monitoring-Tempelan'; 
          }
          });</script>";
      }	
      if ($sqlData2 === false) {
          $errors = sqlsrv_errors();
          $msg = "";
          if ($errors !== null) {
            foreach ($errors as $err) {
              $msg .= "SQLSTATE: " . $err['SQLSTATE'] . "\n";
              $msg .= "Kode: " . $err['code'] . "\n";
              $msg .= "Pesan: " . $err['message'] . "\n\n";
            }
          }
          echo "
          <script>
            swal({
              title: 'Error SQL Server!',
              text: `" . addslashes($msg) . "`,
              icon: 'error',
            });
          </script>";

          exit; 
        }
      // Query 3: Update tbl_schedule
      // $sqlD = sqlsrv_query($con,"UPDATE db_dying.tbl_schedule SET 
      //   status='sedang jalan',
      //   tgl_update=GETDATE()
      //   WHERE status='antri mesin' AND no_mesin='".$rcek['no_mesin']."' AND no_urut='1'"
      // );
      // if (!$sqlD) {
      //   throw new Exception("Gagal update tbl_schedule");
      // }

      // echo "<script>swal({
      //   title: 'Data Tersimpan',   
      //   text: 'Klik Ok untuk input data kembali',
      //   type: 'success',
      // }).then((result) => {
      //   if (result.value) {
      //     window.location.href='?p=Monitoring-Tempelan'; 
      //   }
      // });</script>";
      // sqlsrv_rollback($con);

      // echo "<script>swal({
      //   title: 'Gagal Menyimpan Data',   
      //   text: 'Kesalahan: " . addslashes($e->getMessage()) . "',
      //   type: 'error',
      // }).then((result) => {
      //   if (result.value) {
      //     window.location.href='?p=Monitoring-Tempelan'; 
      //   }
      // });</script>";
}
  
?>