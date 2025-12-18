<?php

include "koneksiLAB.php";
include "koneksi.php";
//db_connect($db_name);
// $con=sqlsrv_connect("10.0.0.10","dit","4dm1n","db_dying");
$nokk	=	$_GET['nokk'];
$sql_cek= 	"SELECT TOP 1 
				COUNT(*) OVER() as total_rows, 
				* 
				FROM 
					db_dying.tbl_schedule 
				WHERE 
					nokk='$nokk' 
				ORDER BY 
					id DESC ";
$sqlCek	=	sqlsrv_query($con,$sql_cek);
$rcek	=	sqlsrv_fetch_array($sqlCek);
$cek 	= 	$rcek['total_rows'];
$query_cek1 = "SELECT TOP 1 
					COUNT(*) OVER() as total_rows, 
					* 
				FROM 
					db_dying.tbl_montemp 
				WHERE 
					nokk='$nokk' 
					and (status='antri mesin' or status='sedang jalan') 
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
// $Kapasitas	= isset($_POST['kapasitas']) ? $_POST['kapasitas'] : '';
// $TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
// $Item		= isset($_POST['item']) ? $_POST['item'] : '';
// $Warna		= isset($_POST['warna']) ? $_POST['warna'] : '';
// $Langganan	= isset($_POST['langganan']) ? $_POST['langganan'] : '';
?>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
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
				  <input name="nokk" type="text" class="form-control" id="nokk" 
                     onchange="window.location='?p=Form-Monitoring-Washing&nokk='+this.value" value="<?php echo $_GET['nokk'];?>" placeholder="No KK" required >
		          </div>
			      <div class="col-sm-4">
				  <input name="id" type="hidden" class="form-control" id="id" value="<?php echo $rcek['id'];?>" placeholder="ID">
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
					  <span class="input-group-addon">KGs</span></div>  
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
                  <label for="no_resep" class="col-sm-3 control-label">No Bon Resep 1</label>
                  <div class="col-sm-3">
                    <input name="no_resep" type="text" class="form-control" id="no_resep" 
                    value="<?php if($cek>0){echo $rcek['no_resep'];} ?>" placeholder="No Bon Resep 1" >
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="no_resep2" class="col-sm-3 control-label">No Bon Resep 2</label>
                  <div class="col-sm-3">
                    <input name="no_resep2" type="text" class="form-control" id="no_resep2" 
                    value="<?php if($cek>0){echo $rcek['no_resep2'];} ?>" placeholder="No Bon Resep 2" >
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="a_dingin" class="col-sm-3 control-label">Pemakaian Air</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="pakai_air" type="text" class="form-control" id="pakai_air" 
                    value="<?php echo $row['VOLUME']; ?>" placeholder="0.00" style="text-align: right;">
					<span class="input-group-addon">L</span></div>  
          </div>				   
        </div>
		<div class="form-group">
		  <label for="benang" class="col-sm-3 control-label">Benang</label>                  
<div class="col-sm-8">
            <input name="benang" type="text" class="form-control" id="benang" 
                    value="<?php echo $bng; ?>" placeholder="Benang" >
          </div>				   
        </div>
		<div class="form-group">
          <label for="std_cok_wrn" class="col-sm-3 control-label">Standar Cocok Warna</label>                  
<div class="col-sm-6">
            <input name="std_cok_wrn" type="text" class="form-control" id="std_cok_wrn" 
                    value="<?php if ($ssr['Flag']==" 1") { echo "Original Color" ; } elseif ($ssr['Flag']=="2" ) { echo "Color LD" ; } else { echo
											  $ssr['OtherDesc']; }?>" placeholder="Standar Cocok Warna" >
          </div>				   
        </div> 	  
		<div class="form-group">
                  <label for="shift" class="col-sm-3 control-label">Shift</label>
                  <div class="col-sm-2">					  
						  <select name="shift" class="form-control" required>
							  	<option value="">Pilih</option>
							  	<option value="1">1</option>
							    <option value="2">2</option>
							  	<option value="3">3</option>
					  </select>
				  </div>
					  
		</div>
		<div class="form-group">
                  <label for="g_shift" class="col-sm-3 control-label">Group Shift</label>
                  <div class="col-sm-2">					  
						  <select name="g_shift" class="form-control" required>
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
				    <select name="operator" class="form-control" required>
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
		<!--  
		<div class="form-group">
          <label for="colorist" class="col-sm-3 control-label">Colorist </label>
                  <div class="col-sm-5">					  
				    <select name="colorist" class="form-control" required>
							  	<option value="">Pilih</option>
							  <?php 
							  $sqlKap=sqlsrv_query($con,"SELECT nama FROM db_dying.tbl_staff WHERE jabatan='Colorist' ORDER BY nama ASC");
							  while($rK=sqlsrv_fetch_array($sqlKap)){
							  ?>
								  <option value="<?php echo $rK['nama']; ?>"><?php echo $rK['nama']; ?></option>
							 <?php } ?>	  
					  </select>
				  </div>
					  
	    </div>
		-->	
		<div class="form-group">
          <label for="leader" class="col-sm-3 control-label">Leader </label>
                  <div class="col-sm-5">					  
				    <select name="leader" class="form-control" required>
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
		<div class="form-group">
                  <label for="a_dingin" class="col-sm-3 control-label">No. Program</label>
                  <div class="col-sm-3">
                    <input name="no_program" type="text" class="form-control" id="no_program" 
                    value="" placeholder="No. Program" >
                  </div>				   
        </div>
		<div class="form-group">
			  <label for="l_g" class="col-sm-3 control-label">L X Grm Sebelum</label>
			  <div class="col-sm-2">
				<input name="lebar_a" type="text" class="form-control" id="lebar_a" 
				value="" placeholder="0" required>
			  </div>
			  <div class="col-sm-2">
				<input name="grms_a" type="text" class="form-control" id="grms_a" 
				value="" placeholder="0" required onChange="hitung();">
			  </div>		
		</div>
		<div class="form-group">
			  <label for="l_g1" class="col-sm-3 control-label">L X Grm Sesudah</label>
			  <div class="col-sm-2">
				<input name="lebar1_a" type="text" class="form-control" id="lebar1_a" 
				value="" placeholder="0" required onChange="susut();">
			  </div>
			  <div class="col-sm-2">
				<input name="grms1_a" type="text" class="form-control" id="grms1_a" 
				value="" placeholder="0" required>
			  </div>		
		</div> 
		<div class="form-group">
                  <label for="susut_lebar" class="col-sm-3 control-label">Susut Lebar</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="susut_lebar" type="text" style="text-align: right;" class="form-control" id="susut_lebar" 
                    value="" placeholder="0.00" >
					<span class="input-group-addon">%</span>
				</div>	
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="susut_panjang" class="col-sm-3 control-label">Susut Panjang</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="susut_panjang" type="text" style="text-align: right;" class="form-control" id="susut_panjang" 
                    value="" placeholder="0.00" >
					<span class="input-group-addon">%</span>
				</div>	
                  </div>				   
        </div> 
		<div class="form-group">
                  <label for="pjng_kain" class="col-sm-3 control-label">Panjang Kain</label>
                  <div class="col-sm-3">
                    <input name="pjng_kain" type="text" class="form-control" id="pjng_kain" 
                    value="<?php if($cek>0){echo $rcek['pnjg_kain'];} ?>" placeholder="0.00" style="text-align: right;" readonly>
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="speed" class="col-sm-3 control-label">speed</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="speed" type="text" style="text-align: right;" class="form-control" id="speed" 
                    value="" placeholder="0.00" >
					<span class="input-group-addon">m/mnt</span>
				</div>	
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="vacum" class="col-sm-3 control-label">Vacuum Pump</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="vacum" type="text" style="text-align: right;" class="form-control" id="vacum" 
                    value="" placeholder="0.00" >
					<span class="input-group-addon">%</span>
				</div>	
                  </div>				   
        </div>  
	  </div>
	  	
	  		<!-- col --> 
	  <div class="col-md-6">		
		<div class="form-group">
                  <label for="ch1" class="col-sm-3 control-label">Chamber 1</label>
                  <div class="col-sm-2">
				   <div class="input-group">	  
                    <input name="ch1" type="text" class="form-control" id="ch1" 
                    value="" placeholder="0" >
					<span class="input-group-addon">&deg;</span>
			       </div>  
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="ch2" class="col-sm-3 control-label">Chamber 2</label>
                  <div class="col-sm-2">
                    <div class="input-group">	  
                    <input name="ch2" type="text" class="form-control" id="ch2" 
                    value="" placeholder="0" >
					<span class="input-group-addon">&deg;</span>
			       </div>
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="ch3" class="col-sm-3 control-label">Chamber 3</label>
                  <div class="col-sm-2">
                    <div class="input-group">	  
                    <input name="ch3" type="text" class="form-control" id="ch3" 
                    value="" placeholder="0" >
					<span class="input-group-addon">&deg;</span>
			       </div>
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="ch4" class="col-sm-3 control-label">Chamber 4</label>
                  <div class="col-sm-2">
                    <div class="input-group">	  
                    <input name="ch4" type="text" class="form-control" id="ch4" 
                    value="" placeholder="0" >
					<span class="input-group-addon">&deg;</span>
			       </div>
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="ch5" class="col-sm-3 control-label">Chamber 5</label>
                  <div class="col-sm-2">
                    <div class="input-group">	  
                    <input name="ch5" type="text" class="form-control" id="ch5" 
                    value="" placeholder="0" >
					<span class="input-group-addon">&deg;</span>
			       </div>
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="ch6" class="col-sm-3 control-label">Chamber 6</label>
                  <div class="col-sm-2">
                    <div class="input-group">	  
                    <input name="ch6" type="text" class="form-control" id="ch6" 
                    value="" placeholder="0" >
					<span class="input-group-addon">&deg;</span>
                  </div>
				  </div>	  
        </div> 
			
	  	<div class="form-group">
                  <label for="vr1" class="col-sm-3 control-label">VR 1</label>
                  <div class="col-sm-2">
                    <input name="vr1" type="text" class="form-control" id="vr1" 
                    value="" placeholder="0" >
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="vr2" class="col-sm-3 control-label">VR 2</label>
                  <div class="col-sm-2">
                    <input name="vr2" type="text" class="form-control" id="vr2" 
                    value="" placeholder="0" >
                  </div>				   
        </div>
		<div class="form-group">
          		  <label for="vr3" class="col-sm-3 control-label">VR 3</label>
                  <div class="col-sm-2">
                    <input name="vr3" type="text" class="form-control" id="vr3" 
                    value="" placeholder="0" >
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="vr4" class="col-sm-3 control-label">VR 4</label>
                  <div class="col-sm-2">
                    <input name="vr4" type="text" class="form-control" id="vr4" 
                    value="" placeholder="0" >
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="vr5" class="col-sm-3 control-label">VR 5</label>
                  <div class="col-sm-2">
                    <input name="vr5" type="text" class="form-control" id="vr5" 
                    value="" placeholder="0" >
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="vr6" class="col-sm-3 control-label">VR 6</label>
                  <div class="col-sm-2">
                    <input name="vr6" type="text" class="form-control" id="vr6" 
                    value="" placeholder="0" >
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="vr7" class="col-sm-3 control-label">VR 7</label>
                  <div class="col-sm-2">
                    <input name="vr7" type="text" class="form-control" id="vr7" 
                    value="" placeholder="0" >
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="vr8" class="col-sm-3 control-label">VR 8</label>
                  <div class="col-sm-2">
                    <input name="vr8" type="text" class="form-control" id="vr8" 
                    value="" placeholder="0" >
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="vr9" class="col-sm-3 control-label">VR 9</label>
                  <div class="col-sm-2">
                    <input name="vr9" type="text" class="form-control" id="vr9" 
                    value="" placeholder="0" >
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="vr10" class="col-sm-3 control-label">VR 10</label>
                  <div class="col-sm-2">
                    <input name="vr10" type="text" class="form-control" id="vr10" 
                    value="" placeholder="0" >
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="vr11" class="col-sm-3 control-label">VR 11</label>
                  <div class="col-sm-2">
                    <input name="vr11" type="text" class="form-control" id="vr11" 
                    value="" placeholder="0" >
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="vr12" class="col-sm-3 control-label">VR 12</label>
                  <div class="col-sm-2">
                    <input name="vr12" type="text" class="form-control" id="vr12" 
                    value="" placeholder="0" >
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="vr13" class="col-sm-3 control-label">VR 13</label>
                  <div class="col-sm-2">
                    <input name="vr13" type="text" class="form-control" id="vr13" 
                    value="" placeholder="0" >
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="vr14" class="col-sm-3 control-label">VR 14</label>
                  <div class="col-sm-2">
                    <input name="vr14" type="text" class="form-control" id="vr14" 
                    value="" placeholder="0" >
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="vr15" class="col-sm-3 control-label">VR 15</label>
                  <div class="col-sm-2">
                    <input name="vr15" type="text" class="form-control" id="vr15" 
                    value="" placeholder="0" >
                  </div>				   
        </div>
		  <!--
		  <div class="form-group">
                  <label for="tgl_buat" class="col-sm-3 control-label">Jam Masuk Kain</label>
			      <div class="col-sm-3">
				  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="waktu_buat" id="waktu_buat" placeholder="00:00" required>				  
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                   </div>
                  </div>
			</div>	  
                  <div class="col-sm-4">					  
						  <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl_buat" type="text" class="form-control pull-right" id="datepicker3" placeholder="0000-00-00" value="" required/>
          </div>
				  </div>
					  
		</div> 
		  -->
		<div class="form-group">
                  <label for="ket" class="col-sm-3 control-label">Keterangan</label>
                  <div class="col-sm-8">					  
						  <textarea name="ket" class="form-control"><?php echo $ketsts;?></textarea>
				  </div>
					  
		</div>  
      </div>
	  		
	 
		  <input type="hidden" value="<?php if($cek>0){echo $rcek['no_ko'];}else{echo $rKO['KONo'];}?>" name="no_ko">
		  <input type="hidden" value="<?php if($cek>0){echo cekDesimal($rcek['target']);}else{echo cekDesimal($rKO['target']);}?>" name="target">	
		  
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
		window.location='index1.php?p=Form-Monitoring-Washing';
	}});</script>";	
   } else if($rcek['no_urut']!="1" and $nokk!=""){
	echo "<script>swal({
  title: 'Harus No Urut `1` ',
  text: 'Klik Ok untuk input kembali',
  type: 'warning',
  }).then((result) => {
  if (result.value) {
    window.location='index1.php?p=Form-Monitoring-Washing';
  }
});</script>"; }else{ ?>	   
   <button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button> 
   <?php } ?>
   
   </div>
    <!-- /.box-footer -->
 </div>
</form>
    
						
                    

<?php 
	if($_POST['save']=="save"){
	  $benang=str_replace("'","''",$_POST['benang']);
	  $tglbuat = ($_POST['tgl_buat'] != '' && $_POST['waktu_buat'] != '') ? $_POST['tgl_buat'] . " " . $_POST['waktu_buat'] : null;
	  $pakai_air=is_numeric($_POST['pakai_air']) ? ceil($_POST['pakai_air']) : null;
	  $target_menit = is_numeric($_POST['target']) ? $_POST['target'] : 0;
	  $query = "INSERT INTO db_dying.tbl_montemp 
				(   id_schedule, nokk, operator, colorist, leader,
					pakai_air, carry_over, shift, gramasi_a, lebar_a, gramasi_s,
					lebar_s, pjng_kain, rol, bruto, g_shift, no_program,
					benang, std_cok_wrn, speed, susut_lebar, susut_panjang, vacum,
					ch1, ch2, ch3, ch4, ch5, ch6, vr1, vr2, vr3, vr4, vr5, vr6,
					vr7, vr8, vr9, vr10, vr11, vr12, vr13, vr14, vr15, ket, 
					tgl_buat, tgl_target, tgl_update)
				VALUES(
					?, ?, ?, ?, ?, 
					?, ?, ?, ?, ?, ?, 
					?, ?, ?, ?, ?, ?, 
					?, ?, ?, ?, ?, ?, 
					?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
					?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
					GETDATE(), DATEADD(MINUTE, CAST(? AS INT), GETDATE()), GETDATE()
				)";
		$params = [ 
					$_POST['id'],
					$_POST['nokk'],
					$_POST['operator'],
					$_POST['colorist'],
					$_POST['leader'],
					$pakai_air,
					$_POST['carry_over'],
					$_POST['shift'],
					$_POST['grms_a'],
					$_POST['lebar_a'],
					$_POST['grms1_a'],
					$_POST['lebar1_a'],
					$_POST['pjng_kain'],
					$_POST['qty3'],
					$_POST['qty4'],
					$_POST['g_shift'],
					$_POST['no_program'],
					$benang,
					$_POST['std_cok_wrn'],
					$_POST['speed'],
					$_POST['susut_lebar'],
					$_POST['susut_panjang'],
					$_POST['vacum'],
					$_POST['ch1'], $_POST['ch2'], $_POST['ch3'], $_POST['ch4'], $_POST['ch5'], $_POST['ch6'],
					$_POST['vr1'], $_POST['vr2'], $_POST['vr3'], $_POST['vr4'], $_POST['vr5'], $_POST['vr6'],
					$_POST['vr7'], $_POST['vr8'], $_POST['vr9'], $_POST['vr10'], $_POST['vr11'], $_POST['vr12'],
					$_POST['vr13'], $_POST['vr14'], $_POST['vr15'],
					$_POST['ket'],
					$target_menit
				];

	$sqlData = sqlsrv_query($con, $query, $params);

		if($sqlData){
			/*$sqlD=sqlsrv_query("UPDATE tbl_schedule SET 
		  status='sedang jalan',
		  tgl_update=now()
		  WHERE id='$_POST[id]' ");*/
			
			$sqlD=sqlsrv_query($con,"UPDATE db_dying.tbl_schedule SET 
			status='sedang jalan',
			tgl_update=GETDATE()
			WHERE status='antri mesin' and no_mesin='".$rcek['no_mesin']."' and no_urut='1' ");
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
		if ($sqlData === false) {
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
	}
?>
<script>
function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}	
function hitung(){
		if(document.forms['form1']['lebar_a'].value != "" && document.forms['form1']['grms_a'].value != ""){
			var brtKain=document.forms['form1']['qty4'].value;
			var lebar=document.forms['form1']['lebar_a'].value;
			var grms=document.forms['form1']['grms_a'].value;
			var m;
			m=roundToTwo((brtKain*39.37*1000)/(lebar*grms));
			document.forms['form1']['pjng_kain'].value=m;
		}
	}
function susut(){
	var sebelum=document.forms['form1']['lebar_a'].value;
	var sesudah=document.forms['form1']['lebar1_a'].value;
	var susut_lebar;
	susut_lebar=roundToTwo((sesudah-sebelum)*100/sebelum);
	document.forms['form1']['susut_lebar'].value=susut_lebar;
}	
</script>