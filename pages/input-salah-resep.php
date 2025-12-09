<?php
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
$nokk=$_GET['nokk'];
$sqlCek=mysqli_query($con,"SELECT 
a.*, c.id as idc FROM tbl_schedule a 
LEFT JOIN tbl_montemp b ON a.id=b.`id_schedule` 
LEFT JOIN tbl_hasilcelup c ON b.id=c.`id_montemp` 
WHERE c.nokk='$nokk' 
AND (c.proses='Celup Greige' OR c.proses='Cuci Misty' OR c.proses='Cuci Yarn Dye (Y/D)')
ORDER BY a.id DESC LIMIT 1");
$cek=mysqli_num_rows($sqlCek);
$rcek=mysqli_fetch_array($sqlCek);

$sqlCek1=mysqli_query($con,"SELECT * FROM tbl_salahresep WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
$cek1=mysqli_num_rows($sqlCek1);
$rcek1=mysqli_fetch_array($sqlCek1);
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
                     	onchange="window.location='?p=Input-Salah-Resep&nokk='+this.value" value="<?php echo $_GET['nokk'];?>" placeholder="No KK" required >
		  			</div>
			      	<div class="col-sm-4">
				  		<input name="id" type="hidden" class="form-control" id="id" value="<?php echo $rcek['idc'];?>" placeholder="ID">
		          	</div>
        		</div>		  
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Langganan</label>
					<div class="col-sm-8">
						<input name="langganan" type="text" class="form-control" id="langganan" placeholder="Langganan" 
						value="<?php if($cek>0){echo $rcek['langganan'];}else{echo $pelanggan;}?>" readonly="readonly">
					</div>				   
				</div>
				<div class="form-group">
					<label for="buyer" class="col-sm-3 control-label">Buyer</label>
					<div class="col-sm-8">
						<input name="buyer" type="text" class="form-control" id="buyer" placeholder="Buyer" 
						value="<?php if($cek>0){echo $rcek['buyer'];}else{echo $buyer;}?>" readonly="readonly">
					</div>				   
				</div>
				<div class="form-group">
					<label for="no_order" class="col-sm-3 control-label">No Order</label>
					<div class="col-sm-4">
						<input name="no_order" type="text" required class="form-control" id="no_order" placeholder="No Order" 
						value="<?php if($cek>0){echo $rcek['no_order'];}else{if($r['NoOrder']!=""){echo $r['NoOrder'];}else if($nokk!=""){echo $cekM['no_order'];}} ?>" readonly="readonly">
					</div>				   
				</div>
				<div class="form-group">
					<label for="no_po" class="col-sm-3 control-label">PO</label>
					<div class="col-sm-5">
						<input name="no_po" type="text" class="form-control" id="no_po" placeholder="PO" 
						value="<?php if($cek>0){echo $rcek['po'];}else{if($r['PONumber']!=""){echo $r['PONumber'];}else if($nokk!=""){echo $cekM['no_po'];}} ?>" readonly="readonly" >
					</div>				   
				</div>
				<div class="form-group">
					<label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
					<div class="col-sm-8">
						<textarea name="jns_kain" readonly="readonly" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?php if($cek>0){echo $rcek['jenis_kain'];}else{if($r['ProductDesc']!=""){echo $r['ProductDesc'];}else if($nokk!=""){ echo $cekM['jenis_kain']; } }?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="warna" class="col-sm-3 control-label">Warna</label>
					<div class="col-sm-8">
						<input name="warna" type="text" class="form-control" id="warna" placeholder="Warna" 
						value="<?php if($cek>0){echo $rcek['warna'];}else{if($r['Color']!=""){echo $r['Color'];}else if($nokk!=""){ echo $cekM['warna'];} }?>" readonly="readonly">  
					</div>				   
				</div>
				<div class="form-group">
					<label for="no_warna" class="col-sm-3 control-label">No Warna</label>
					<div class="col-sm-8">
						<input name="no_warna" type="text" class="form-control" id="no_warna" placeholder="No Warna" 
						value="<?php if($cek>0){echo $rcek['no_warna'];}else{if($r['ColorNo']!=""){echo $r['ColorNo'];}else if($nokk!=""){echo $cekM['no_warna'];}}?>" readonly="readonly">  
					</div>				   
				</div>    
			</div>
	  		<!-- col --> 
	  		<div class="col-md-6">
			  	<div class="form-group">
                 	<label for="shift" class="col-sm-3 control-label">Shift</label>
                  	<div class="col-sm-2">					  
						<select name="shift" class="form-control" required>
							<option value="">Pilih</option>
							<option value="1" <?php if($rcek1['shift']=="1"){echo "SELECTED";}?>>1</option>
							<option value="2" <?php if($rcek1['shift']=="2"){echo "SELECTED";}?>>2</option>
							<option value="3" <?php if($rcek1['shift']=="3"){echo "SELECTED";}?>>3</option>
					  	</select>
				  	</div>	
				</div>
				<div class="form-group">
					<label for="g_shift" class="col-sm-3 control-label">Group Shift</label>
					<div class="col-sm-2">					  
						<select name="g_shift" class="form-control" required>
							<option value="">Pilih</option>
							<option value="A" <?php if($rcek1['g_shift']=="A"){echo "SELECTED";}?>>A</option>
							<option value="B" <?php if($rcek1['g_shift']=="B"){echo "SELECTED";}?>>B</option>
							<option value="C" <?php if($rcek1['g_shift']=="C"){echo "SELECTED";}?>>C</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="lot" class="col-sm-3 control-label">Lot</label>
					<div class="col-sm-2">
						<input name="lot" type="text" class="form-control" id="lot" placeholder="Lot" 
						value="<?php if($cek>0){echo $rcek['lot'];}else{if($nomorLot!=""){echo $lotno;}else if($nokk!=""){echo $cekM['lot'];} } ?>" readonly="readonly" >
					</div>				   
				</div>
				<div class="form-group">
					<label for="jml_bruto" class="col-sm-3 control-label">Rol &amp; Qty</label>
					<div class="col-sm-2">
						<input name="roll" type="text" required class="form-control" id="roll" placeholder="0.00" 
						value="<?php if($cek>0){echo $rcek['rol'];} ?>" readonly="readonly">
					</div>
					<div class="col-sm-3">
						<div class="input-group">  
							<input name="qty" type="text" required class="form-control" id="qty" placeholder="0.00" style="text-align: right;" 
							value="<?php if($cek>0){echo $rcek['bruto'];} ?>" readonly="readonly">
							<span class="input-group-addon">KGs</span>
						</div>	
					</div>		
				</div>
				<div class="form-group">
					<label for="jenis_kesalahan" class="col-sm-3 control-label">Jenis Kesalahan</label>
					<div class="col-sm-7">
						<div class="input-group">
						<select class="form-control select2" multiple="multiple" data-placeholder="Jenis Kesalahan" name="jenis_kesalahan[]" id="jenis_kesalahan" required>
							<option value="">Pilih</option>
							<?php
							$dtArr=$rcek1['jenis_kesalahan'];	
							$data = explode(",",$dtArr);
							$qCek1=mysqli_query($con,"SELECT jenis_salah FROM tbl_jenis_salah ORDER BY jenis_salah ASC");
							$i=0;	
							while($dCek1=mysqli_fetch_array($qCek1)){ ?>
							<option value="<?php echo $dCek1['jenis_salah'];?>" <?php if($dCek1['jenis_salah']==$data[0] or $dCek1['jenis_salah']==$data[1] or $dCek1['jenis_salah']==$data[2] or $dCek1['jenis_salah']==$data[3] or $dCek1['jenis_salah']==$data[4] or $dCek1['jenis_salah']==$data[5]){echo "SELECTED";} ?>><?php echo $dCek1['jenis_salah'];?></option>
							<?php $i++;} ?> 
						</select>
						<span class="input-group-btn"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#DataJenisSalah"> ...</button></span>
						</div>
		 	 		</div>
				</div>
				<div class="form-group">
          			<label for="acc1" class="col-sm-3 control-label">Penanggung Jawab 1 </label>
                  	<div class="col-sm-5">					  
				    	<select name="acc1" class="form-control select2" required>
							<option value="">Pilih</option>
							<?php 
							$sqlKap=mysqli_query($con,"SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while($rK=mysqli_fetch_array($sqlKap)){
							?>
							<option value="<?php echo $rK['nama']; ?>" <?php if($rcek1['t_jawab1']==$rK['nama']){echo "SELECTED";} ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
							<option value="UNGGUL SATRIA" <?php if($rcek1['t_jawab1']=="UNGGUL SATRIA"){echo "SELECTED";} ?>>UNGGUL SATRIA</option>
							<option value="FAHRUDIN" <?php if($rcek1['t_jawab1']=="FAHRUDIN"){echo "SELECTED";} ?>>FAHRUDIN</option>		  
							<option value="DEDI I" <?php if($rcek1['t_jawab1']=="DEDI I"){echo "SELECTED";} ?>>DEDI I</option>
					  	</select>
				  	</div>
	    		</div>  
				<div class="form-group">
         		 	<label for="acc2" class="col-sm-3 control-label">Penanggung Jawab 2 </label>
                  	<div class="col-sm-5">					  
						<select name="acc2" class="form-control select2">
							<option value="">Pilih</option>
							<?php 
							$sqlKap=mysqli_query($con,"SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while($rK=mysqli_fetch_array($sqlKap)){
							?>
							<option value="<?php echo $rK['nama']; ?>" <?php if($rcek1['t_jawab2']==$rK['nama']){echo "SELECTED";} ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
							<option value="UNGGUL SATRIA" <?php if($rcek1['t_jawab2']=="UNGGUL SATRIA"){echo "SELECTED";} ?>>UNGGUL SATRIA</option>
							<option value="FAHRUDIN" <?php if($rcek1['t_jawab2']=="FAHRUDIN"){echo "SELECTED";} ?>>FAHRUDIN</option>		  
							<option value="DEDI I" <?php if($rcek1['t_jawab2']=="DEDI I"){echo "SELECTED";} ?>>DEDI I</option>	  
						</select>
				  	</div>
	    		</div>
				<div class="form-group">
					<label for="ket" class="col-sm-3 control-label">Keterangan</label>
					<div class="col-sm-8">					  
							<textarea name="ket" class="form-control"><?php if($cek1>0){echo $rcek1['ket'];}?></textarea>
					</div>
				</div>  
      		</div>  		
 		</div>
   		<div class="box-footer">
			<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Input-Salah-Resep'">Batal <i class="fa fa-arrow-circle-o-left"></i></button>
			<?php if($cek1>0){ ?> 	
            <button type="submit" class="btn btn-primary pull-right" name="update" value="update"><i class="fa fa-edit"></i> Update</button> 
            <?php }else if($_GET['nokk']!="" and $cek1==0){?>
            <button type="submit" class="btn btn-primary pull-right" name="simpan" value="simpan"><i class="fa fa-save"></i> Simpan</button> 
            <?php } ?> 
   		</div>
    	<!-- /.box-footer -->
 	</div>
</form>

<?php 
	if($_POST['simpan']=="simpan" AND $cek==0){
		echo "<script>swal({
			title: 'Data No KK Tidak Sesuai',   
			text: 'Klik Ok untuk input data kembali',
			type: 'info',
			}).then((result) => {
			if (result.value) {
			  
			   window.location.href='?p=Input-Salah-Resep'; 
			}
		  });</script>";
	}else if($_POST['simpan']=="simpan"){			
	  $ket=str_replace("'","''",$_POST['ket']);
	  if(isset($_POST["jenis_kesalahan"]))  
        { 
            // Retrieving each selected option 
            foreach ($_POST['jenis_kesalahan'] as $index => $subject1){
				   if($index>0){
					  $jk1=$jk1.",".$subject1; 
				   }else{
					   $jk1=$subject1;
				   }	
				    
			}
        } 
  	  $sqlData=mysqli_query($con,"INSERT INTO tbl_salahresep SET
	  	id_celup='$_POST[id]',
		nokk='$_POST[nokk]',
		shift='$_POST[shift]',
		g_shift='$_POST[g_shift]',
		jenis_kesalahan='$jk1',
		t_jawab1='$_POST[acc1]',
		t_jawab2='$_POST[acc2]',
		ket='$ket',
		tgl_buat=now(),
		tgl_update=now()
        ");	 	  
	  
		if($sqlData){  
			echo "<script>swal({
  title: 'Data Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    
	 window.location.href='?p=Input-Salah-Resep'; 
  }
});</script>";
		}
			
	}
    if($_POST['update']=="update"){
	  $ket=str_replace("'","''",$_POST['ket']);	
	  if(isset($_POST["jenis_kesalahan"]))  
        { 
            // Retrieving each selected option 
            foreach ($_POST['jenis_kesalahan'] as $index => $subject1){
				   if($index>0){
					  $jk1=$jk1.",".$subject1; 
				   }else{
					   $jk1=$subject1;
				   }	
				    
			}
        }
  	  $sqlData=mysqli_query($con,"UPDATE tbl_salahresep SET 
	      id_celup='$_POST[id]',
		  shift='$_POST[shift]',
		  g_shift='$_POST[g_shift]',
		  jenis_kesalahan='$jk1',
		  t_jawab1='$_POST[acc1]',
		  t_jawab2='$_POST[acc2]',
		  ket='$ket',
		  tgl_update=now()
		  WHERE nokk='$_POST[nokk]'");	 	  
	  
		if($sqlData){			
			echo "<script>swal({
  title: 'Data Telah DiUbah',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    
	 window.location.href='?p=Input-Salah-Resep'; 
  }
});</script>";
		}
		
			
	}
?>
<div class="modal fade" id="DataJenisSalah">
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Jenis Kesalahan</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="form-group">
                  <label for="jenis_salah" class="col-md-3 control-label">Jenis Kesalahan</label>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="jenis_salah" name="jenis_salah" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>		    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<input type="submit" value="Simpan" name="simpan_kesalahan" id="simpan_kesalahan" class="btn btn-primary pull-right" >  
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>
<?php 
if($_POST['simpan_kesalahan']=="Simpan"){
	$jenis_salah=strtoupper($_POST['jenis_salah']);
	$sqlData1=mysqli_query($con,"INSERT INTO tbl_jenis_salah SET 
		  jenis_salah='$jenis_salah'");
	if($sqlData1){	
	echo "<script>swal({
  title: 'Data Telah Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
         window.location.href='?p=Input-Salah-Resep';
	 
  }
});</script>";
		}
}
?>
