<?php
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
$nokk=$_GET['nokk'];
$nokkNCP=$_GET['nokkncp'];
$jd="NCP";
$manual=$_GET['manual'];

$sqlCekNM=mysqli_query($con,"SELECT * FROM tbl_ncp_memo WHERE jnsdata='NCP' and nokk='$nokk' and nokk_ncp='$nokkNCP' and no_ncp='$NCPNO'");
$cekNM=mysqli_num_rows($sqlCekNM);
$rcekNM=mysqli_fetch_array($sqlCekNM);

$sqlCek=mysqli_query($con,"SELECT
	a.*,b.id as idm 
FROM
	tbl_schedule a
LEFT JOIN tbl_montemp b ON a.id=b.id_schedule	
WHERE
	a.nokk = '$nokk' and not (a.no_mesin='CB11' or a.no_mesin='WS11')
ORDER BY
	a.id DESC 
	LIMIT 1");
$cek=mysqli_num_rows($sqlCek);
$rcek=mysqli_fetch_array($sqlCek);
$sqlCek1=mysqli_query($con,"SELECT
	c.*,a.id as ids,b.id as idm 
FROM
	tbl_schedule a
INNER JOIN tbl_montemp b ON a.id=b.id_schedule
INNER JOIN tbl_hasilcelup c ON b.id=c.id_montemp
WHERE
	a.nokk = '$nokk' and b.status='selesai'
ORDER BY
	a.id DESC 
	LIMIT 1");
$cek1=mysqli_num_rows($sqlCek1);
$rcek1=mysqli_fetch_array($sqlCek1);
$qryLama=mysqli_query($con,"SELECT TIME_FORMAT(timediff(now(),b.tgl_buat),'%H:%i') as lama FROM tbl_schedule a
LEFT JOIN tbl_montemp b ON a.id=b.id_schedule
WHERE b.nokk='$nokk' AND b.status='sedang jalan' ORDER BY a.no_urut ASC");
$rLama=mysqli_fetch_array($qryLama);
$sqlCek2=mysqli_query($con,"SELECT
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
	 (`status` = 'sedang jalan' or `status` = 'antri mesin' or `status` = 'selesai') and no_mesin='".$rcek['no_mesin']."' and no_urut='".$rcek['no_urut']."'
GROUP BY
	no_mesin,
	no_urut 
ORDER BY
	id ASC");
$cek2=mysqli_num_rows($sqlCek2);
$rcek2=mysqli_fetch_array($sqlCek2);
if($rcek2['ket_kartu']!=""){$ketsts=$rcek2['ket_kartu']."\n(".$rcek2['g_kk'].")";}else{$ketsts="";}
$sqlCek3=mysqli_query($con,"SELECT * FROM tbl_montemp WHERE id='$rcek[idm]' and (status='antri mesin' or status='sedang jalan' or status='selesai') ORDER BY id DESC LIMIT 1");
$cek3=mysqli_num_rows($sqlCek3);
$rcek3=mysqli_fetch_array($sqlCek3);
$sqlCekAir=mysqli_query($con,"SELECT air_awal,waktu_tunggu FROM tbl_montemp WHERE id='$rcek[idm]' ORDER BY id DESC LIMIT 1");
$cekAir=mysqli_num_rows($sqlCekAir);
$rcekAir=mysqli_fetch_array($sqlCekAir);
$sqlTopping=mysqli_query($con,"SELECT jml_topping FROM tbl_hasilcelup WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
$rTopping=mysqli_fetch_array($sqlTopping);
$sqltarget=mysqli_query($con,"select if(b.tgl_target<=now(),'melebihi target','sedang berjalan') as cek_delay,a.target,(round(left(c.lama_proses,2))+round(right(c.lama_proses,2)/60,2)) as lama_proses,
if(isnull(c.lama_proses),'jalan',if(a.target>=(round(left(c.lama_proses,2))+round(right(c.lama_proses,2)/60,2)),'sesuai target','melebihi target')) as sts from db_dying.tbl_schedule a
left join db_dying.tbl_montemp b on a.id=b.id_schedule
left join db_dying.tbl_hasilcelup c on b.id=c.id_montemp
where b.nokk='$nokk' order by b.id desc limit 1");
$cktarget=mysqli_fetch_array($sqltarget);
$sqlCek4=mysqli_query($con,"SELECT * FROM tbl_montemp WHERE id='$rcek[idm]' ORDER BY id DESC LIMIT 1");
$cek4=mysqli_num_rows($sqlCek4);
$rcek4=mysqli_fetch_array($sqlCek4);
$sqlNCP=mysqli_query($cond,"SELECT * FROM tbl_ncp_qcf_new WHERE (nokk='$nokkNCP' or nokk_salinan='$nokkNCP') and dept='DYE' ORDER BY id DESC LIMIT 1");
$cekNCP=mysqli_fetch_array($sqlNCP);
$sqlNCP1=mysqli_query($cond,"SELECT * FROM tbl_ncp_qcf_new WHERE (nokk='$nokk' or nokk_salinan='$nokk') and dept='DYE' ORDER BY id DESC LIMIT 1");
$cekNCP1=mysqli_fetch_array($sqlNCP1);
if($cekNCP['berat']>0 and $rcek4['bruto']>0){
	$qtyP=round(($cekNCP['berat']/$rcek4['bruto'])*100,2);
}else{
	$qtyP="0";
}

?>
<?php
$Kapasitas	= isset($_POST['kapasitas']) ? $_POST['kapasitas'] : '';
$TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
$Item		= isset($_POST['item']) ? $_POST['item'] : '';
$Warna		= isset($_POST['warna']) ? $_POST['warna'] : '';
$Langganan	= isset($_POST['langganan']) ? $_POST['langganan'] : '';
$NCPNO		= isset($_POST['no_ncp']) ? $_POST['no_ncp'] : '';
$Manual		= isset($_POST['manual']) ? $_POST['manual'] : '';
$tglBuat	= isset($_POST['tglbuat']) ? $_POST['tglbuat'] : '';
?>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
 <div class="box box-info">
  	<div class="box-header with-border">
    <h3 class="box-title">Input  Kartu Kerja NCP</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
 	<div class="box-body"> 
	  <div class="col-md-6">
		<div class="form-group">
                  <label for="no_po" class="col-sm-3 control-label">Manual <?php if($Manual=="ya"){echo "Selected";} echo $Manual;?></label>
                  <div class="col-sm-2">
				  <select name="manual" id="manual" onChange="aktif(); window.location='?p=Form-NCP&manual='+this.value " class="form-control select2">
					  <option value="">Tidak</option>
					  <option value="ya" <?php if($_GET['manual']=="ya"){echo "Selected";} ?>>Ya</option>
				  </select>	  
				  				  	  
		  		  </div>				  
        </div>  
		<div class="form-group">
                  <label for="no_po" class="col-sm-3 control-label">No KK Induk</label>
                  <div class="col-sm-4">
				  <input name="nokk" type="text" class="form-control" id="nokk" 
                     onchange="window.location='?p=Form-NCP&manual=<?php echo $_GET['manual'];?>&nokk='+this.value" value="<?php echo $_GET['nokk'];?>" placeholder="No KK" required >
				  	  
		  		  </div>
				  <div class="col-sm-2">
				  <input name="id" type="hidden" class="form-control" id="id" value="<?php echo $rcek['idm'];?>" placeholder="ID">
		          </div>
        </div>
		<div class="form-group">
                  <label for="no_order" class="col-sm-3 control-label">No Order</label>
                  <div class="col-sm-4">
                    <input name="no_order" type="text" required class="form-control" id="no_order" placeholder="No Order" 
                    value="<?php 
					if($cek>0){
					echo $rcek['no_order'];}
						   else{
							   if($r['NoOrder']!=""){
							   	echo $r['NoOrder'];}
							   else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['no_order'];}
						   	   else if($nokk!=""){
								echo $cekM['no_order'];}
					} ?>" readonly="readonly">
                  </div>				   
        </div>  
		<div class="form-group">
                  <label for="langganan" class="col-sm-3 control-label">Langganan</label>
                  <div class="col-sm-8">
                    <input name="langganan" type="text" class="form-control" id="langganan" placeholder="Langganan" 
                    value="<?php if($cek>0){
							echo $rcek['langganan'];}
						   else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['langganan'];}
						   else{echo $pelanggan;}?>" readonly="readonly">
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="buyer" class="col-sm-3 control-label">Buyer</label>
                  <div class="col-sm-8">
                    <input name="buyer" type="text" class="form-control" id="buyer" placeholder="Buyer" 
                    value="<?php if($cek>0){echo $rcek['buyer'];}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['buyer'];} else{echo $buyer;}?>" readonly="readonly">
                  </div>				   
        </div>	    
	    <div class="form-group">
                  <label for="no_po" class="col-sm-3 control-label">PO</label>
                  <div class="col-sm-5">
                    <input name="no_po" type="text" class="form-control" id="no_po" placeholder="PO" 
                    value="<?php if($cek>0){echo $rcek['po'];}else{if($r['PONumber']!=""){echo $r['PONumber'];}
																   else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['po'];}
																   else if($nokk!=""){echo $cekM['no_po'];}} ?>" readonly="readonly" >
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="no_hanger" class="col-sm-3 control-label">No Hanger / No Item</label>
                  <div class="col-sm-3">
                    <input name="no_hanger" type="text" class="form-control" id="no_hanger" placeholder="No Hanger" 
                    value="<?php if($cek>0){echo $rcek['no_hanger'];}else{if($r['HangerNo']){echo $r['HangerNo'];}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['no_hanger'];} else if($nokk!=""){echo $cekM['no_item'];}}?>" readonly="readonly">  
                  </div>
				  <div class="col-sm-3">
				  <input name="no_item" type="text" class="form-control" id="no_item" placeholder="No Item" 
                    value="<?php if($rcek['no_item']!=""){echo $rcek['no_item'];}else if($r['ProductCode']!=""){echo $r['ProductCode'];}else{if($r['HangerNo']){echo $r['HangerNo'];}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['no_item'];}else if($nokk!=""){echo $cekM['no_item'];}}?>" readonly="readonly">
				  </div>	
        </div>
	    <div class="form-group">
                  <label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
                  <div class="col-sm-8">
					  <textarea name="jns_kain" readonly="readonly" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?php if($cek>0){echo $rcek['jenis_kain'];}else{if($r['ProductDesc']!=""){echo $r['ProductDesc'];}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['jenis_kain'];}else if($nokk!=""){ echo $cekM['jenis_kain']; } }?></textarea>
		  </div>
        </div>
		<div class="form-group">
			  <label for="l_g" class="col-sm-3 control-label">Lebar X Gramasi </label>
			  <div class="col-sm-2">
				<input name="lebar" type="text" required class="form-control" id="lebar" placeholder="0" 
				value="<?php if($cek>0){echo $rcek['lebar'];}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['lebar'];}else{echo round($r['Lebar']);} ?>" readonly="readonly">
			  </div>
			  <div class="col-sm-2">
				<input name="grms" type="text" required class="form-control" id="grms" placeholder="0" 
				value="<?php if($cek>0){echo $rcek['gramasi'];}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['gramasi'];}else{echo round($r['Gramasi']);} ?>" readonly="readonly">
			  </div>		
		</div>
		<div class="form-group">
			  <label for="warna" class="col-sm-3 control-label">Warna</label>
			  <div class="col-sm-8">
				<input name="warna" type="text" class="form-control" id="warna" placeholder="Warna" 
				value="<?php if($cek>0){echo $rcek['warna'];}else{if($r['Color']!=""){echo $r['Color'];}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['warna'];}else if($nokk!=""){ echo $cekM['warna'];} }?>" readonly="readonly">  
			  </div>				   
		</div>
		<div class="form-group">
			  <label for="no_warna" class="col-sm-3 control-label">No Warna</label>
			  <div class="col-sm-8">
				<input name="no_warna" type="text" class="form-control" id="no_warna" placeholder="No Warna" 
				value="<?php if($cek>0){echo $rcek['no_warna'];}else{if($r['ColorNo']!=""){echo $r['ColorNo'];}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['no_warna'];}else if($nokk!=""){echo $cekM['no_warna'];}}?>" readonly="readonly">  
			  </div>				   
		</div>    
		<div class="form-group">
                  <label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="qty1" type="text" required class="form-control" id="qty1" placeholder="0.00" 
                    value="<?php if($cek>0){echo $rcek['qty_order'];}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['berat'];}else{echo round($r['BatchQuantity'],2);} ?>" readonly="readonly">
					  <span class="input-group-addon">KGs</span></div>  
                  </div>
				  <div class="col-sm-4">
					<div class="input-group">  
                    <input name="qty2" type="text" required class="form-control" id="qty2" placeholder="0.00" style="text-align: right;" 
                    value="<?php if($cek>0){echo $rcek['pjng_order'];}else{echo round($r['Quantity'],2);} ?>" readonly="readonly">
                    <span class="input-group-addon">
							  <select name="satuan1" disabled="disabled" style="font-size: 12px;">
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
                    <input name="lot" type="text" class="form-control" id="lot" placeholder="Lot" 
                    value="<?php if($cek>0){echo $rcek['lot'];}else{if($nomorLot!=""){echo $lotno;}else if($nokk!="" and $_GET['manual']=="ya"){
								echo $cekNCP1['lot'];}else if($nokk!=""){echo $cekM['lot'];} } ?>" readonly="readonly" >
                  </div>
				  <label for="po_rajut" class="col-sm-3 control-label">PO Rajut</label>
                  <div class="col-sm-3">
                    <input name="po_rajut" type="text" class="form-control" id="po_rajut" placeholder="PO Rajut" 
                    value="<?php if($nokkNCP!=""){echo $cekNCP['po_rajut'];}?>" readonly="readonly" >
                  </div>
        </div> 		
	  </div>
	  		<!-- col --> 
	  <div class="col-md-6">
		  <div class="form-group">		    
          <label for="nokk_ncp" class="col-sm-3 control-label">KK NCP</label>
          <div class="col-sm-3">
                    <input name="nokk_ncp" type="text" class="form-control" id="nokk_ncp" 
                    onchange="window.location='?p=Form-NCP&manual=<?php echo $_GET['manual'];?>&nokk=<?php echo $_GET['nokk'];?>&nokkncp='+this.value" value="<?php echo $_GET['nokkncp'];?>">
                  </div>		  		  
		  <label for="ncp_hitung" class="col-sm-3 control-label">Hitung NCP</label>
          <div class="col-sm-3">
			  <input name="ncp_hitung" class="form-control" value="<?php if($nokkNCP!=""){echo $cekNCP['ncp_hitung'];} ?>" readonly>			  		
                  </div>
            
        </div>
		<div class="form-group">		    
          <label for="cycle_time" class="col-sm-3 control-label">Tgl Buat</label>	
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tglbuat" type="text" class="form-control pull-right" id="datepicker" placeholder="Tgl Buat" value="<?php echo $tglBuat; ?>" autocomplete="off" required/>
          </div>
        </div>
		  		  
		  <label for="no_ncp" class="col-sm-3 control-label">No NCP</label>
          <div class="col-sm-3"> 
		  <div class="input-group">			   	  
		  <select class="form-control select2" name="no_ncp" id="no_ncp" > 
					<option value="">Cek NCP</option>
					<?php 
			  		if($nokkNCP!=""){$Wncp=" (nokk='$_GET[nokkncp]' or nokk_salinan='$_GET[nokkncp]') and ";}else{
						$Wncp=" nokk='$_GET[nokkncp]' and ";
					}
					$qCek=mysqli_query($cond,"SELECT no_ncp_gabungan FROM tbl_ncp_qcf_new WHERE $Wncp dept='DYE' ORDER BY id DESC");
					while($dCek=mysqli_fetch_array($qCek)){ 
					?>
					<option value="<?php echo $dCek['no_ncp_gabungan'];?>" <?php if($dCek['no_ncp_gabungan']==$NCPNO){echo "SELECTED";}?>><?php echo $dCek['no_ncp_gabungan'];?></option>
					<?php } ?>
				</select>
			<span class="input-group-btn"><button type="submit" class="btn btn-default" name="cekncp" id="cekncp" value="cekncp"> <span class="fa fa-search"></span></button></span>	
				</div>  
			</div>	  
        </div>  
		<div class="form-group">
          <label for="masalah_ncp" class="col-sm-3 control-label">Masalah NCP</label>
          <div class="col-sm-9">
                    <input name="masalah_ncp" type="text" class="form-control" id="masalah_ncp" value="<?php if($nokkNCP!=""){ echo $cekNCP['masalah'];}?>" readonly="readonly">
          </div>				   
        </div>
		<div class="form-group">
          <label for="kategori_masalah" class="col-sm-3 control-label">Kategori Masalah NCP</label>
          <div class="col-sm-5">
            <div class="input-group">	  
		    <select class="form-control select2" name="kategori_masalah" id="kategori_masalah" > 
					<option value="">Pilih</option>
					<?php 
					$qCek=mysqli_query($con,"SELECT kategori_masalah FROM tbl_kategori_masalah_ncp ORDER BY kategori_masalah ASC");
					while($dCek=mysqli_fetch_array($qCek)){ 
					?>
					<option value="<?php echo $dCek['kategori_masalah'];?>" <?php if($dCek['kategori_masalah']==$rcekNM['kategori_penyelesaian']){echo "SELECTED";}?>><?php echo $dCek['kategori_masalah'];?></option>
					<?php } ?>
			</select>
			<span class="input-group-btn"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#DataKategoriMasalah"> ...</button></span>	
				</div>
          </div>				   
        </div>  
		<!--<div class="form-group">
          <label for="masalah_ncp_dye" class="col-sm-3 control-label">Masalah NCP Dyeing</label>
          <div class="col-sm-9">
          <input name="masalah_ncp_dye" type="text" class="form-control" id="masalah_ncp_dye" value="<?php //if($nokkNCP!=""){ echo $cekNCP['masalah_dye']; }?>">
          </div>				   
        </div>-->  
		<div class="form-group">
			  <label for="jml_bruto" class="col-sm-3 control-label">Roll Induk</label>
			  <div class="col-sm-3">
				<input name="qty3" type="text" required class="form-control" id="qty3" placeholder="0.00" 
				value="<?php echo $rcek4['rol']; ?>" >
			  </div>
			  <label for="jml_ncp" class="col-sm-3 control-label">Roll NCP</label>
			  <div class="col-sm-3">
				<input name="jml_ncp" type="text" required class="form-control" id="jml_ncp" placeholder="0.00" 
				value="<?php if($nokkNCP!=""){ echo $cekNCP['rol']; }?>" readonly="readonly">
			  </div>	
			  		
		</div>
		<div class="form-group">
			  <label for="jml_bruto" class="col-sm-3 control-label">Qty Induk</label>
			  <div class="col-sm-3">
				<div class="input-group">  
				<input name="qty4" type="text" required class="form-control" id="qty4" placeholder="0.00" style="text-align: right;" 
				value="<?php echo $rcek4['bruto']; ?>" >
				<span class="input-group-addon">KGs</span>
				</div>	
			  </div>
			  <label for="qty_ncp" class="col-sm-3 control-label">Qty NCP</label>
			  <div class="col-sm-3">
				<div class="input-group">  
				<input name="qty_ncp" type="text" required class="form-control" id="qty_ncp" placeholder="0.00" style="text-align: right;" 
				value="<?php if($nokkNCP!=""){ echo $cekNCP['berat'];} ?>" readonly="readonly">
				<span class="input-group-addon">KGs</span>
				</div>	
			  </div>	
		</div>  
		<?php if($cek>0 and ($rcek['kapasitas']!="" and $rcek['kapasitas']!="0")){$loading=round($rcek['bruto']/$rcek['kapasitas'],4)*100;}else{if($r['Weight']!="" and ($rcek['kapasitas']!="" and $rcek['kapasitas']!="0")){$loading=round($r['Weight']/$rcek['kapasitas'],4)*100;}else if($nokk!="" and ($rcek['kapasitas']!="" and $rcek['kapasitas']!="0")){$loading=round($cekM['bruto']/$rcek['kapasitas'],4)*100;}} ?>  
		<div class="form-group">
                  <label for="no_mc" class="col-sm-3 control-label">No MC</label>
                  <div class="col-sm-2">					  	  	
				   <input name="no_mc" id="no_mc" class="form-control"  value="<?php echo $rcek['no_mesin']; ?>" <?php if($_GET['manual']!="ya"){echo "readonly";} ?>>
				  </div>
					<?php 
					$qMC=mysqli_query($con,"SELECT kode FROM tbl_mesin WHERE no_mesin='$rcek[no_mesin]'");
					$dMC=mysqli_fetch_array($qMC);
					?>
				  <div class="col-sm-2">		  	
              	   <input name="nama_mc" id="nama_mc" class="form-control"  value="<?php echo $dMC['kode']; ?>" <?php if($_GET['manual']!="ya"){echo "readonly";} ?>>
			      </div>	
          <label for="qty_persen" class="col-sm-2 control-label">Qty</label>
          <div class="col-sm-3">
			  <div class="input-group">	
              <input name="qty_persen" type="text" class="form-control" id="qty_persen" value="<?php echo $qtyP; ?>" style="text-align: right;" readonly="readonly">
			  <span class="input-group-addon">&#37;</span>
			  </div>	
                  </div>
					
		</div> 
		<div class="form-group">
		  <label for="tglcelup" class="col-sm-3 control-label">Tgl Celup</label>
          <div class="col-sm-2">
			  		<input name="tglcelup" type="text" class="form-control" id="tglcelup" value="<?php echo substr($rcek4['tgl_buat'],0,10);?>" readonly>	
                  </div>	  
          <label for="shift1" class="col-sm-1 control-label">Shift</label>
          <div class="col-sm-1">
                    <input name="shift1" type="text" class="form-control" id="shift1" value="<?php echo $rcek4['g_shift'];?>" readonly>
                  </div>
		  <label for="tolak" class="col-sm-2 control-label">Acc Tolak QCF</label>
          <div class="col-sm-3">
                    <input name="tolak" type="text" class="form-control" id="tolak" value="<?php echo $rcekNM['tolak_qcf'];?>" >
                  </div>
        </div>  
		<div class="form-group">
          <label for="acc_kain" class="col-sm-3 control-label">Acc Kain Keluar</label>
          <div class="col-sm-3">
                    <input name="acc_kain" type="text" class="form-control" id="acc_kain" value="<?php echo $rcek1['acc_keluar']; ?>" readonly="readonly">
                  </div>	
			<label for="operator" class="col-sm-3 control-label">Operator</label>
          		<div class="col-sm-3">
                    <input name="operator" type="text" class="form-control" id="operator" value="<?php echo $rcek1['operator_keluar']; ?>" readonly="readonly">
                  </div>
        </div>
		<div class="form-group">
          <label for="no_program" class="col-sm-3 control-label">No Program</label>
          <div class="col-sm-2">
                    <input name="no_program" type="text" class="form-control" id="no_program" value="<?php echo $rcek4['no_program']; ?>" readonly="readonly">
                  </div>
		  <label for="press_pump" class="col-sm-4 control-label">Press Pump</label>
          <div class="col-sm-3">
                    <input name="press_pump" type="text" class="form-control" id="press_pump" value="<?php echo $rcek4['tekanan']; ?>" readonly="readonly">
                  </div>	
        </div>
		<div class="form-group">
          <label for="loading" class="col-sm-3 control-label">Loading</label>
          <div class="col-sm-2">
			  <div class="input-group">	
              <input name="loading" type="text" class="form-control" id="loading" value="<?php echo $rcek['loading']; ?>" readonly="readonly">
			  <span class="input-group-addon">&#37;</span>
			  </div>	
                  </div>
		  <label for="nozzle" class="col-sm-4 control-label">Nozzle</label>
          <div class="col-sm-3">
                    <input name="nozzle" type="text" class="form-control" id="nozzle" value="<?php echo $rcek4['nozzle']; ?>" readonly="readonly">
                  </div>	
        </div>  
		<div class="form-group">
          <label for="l_r" class="col-sm-3 control-label">L:R</label>
          <div class="col-sm-3">
                    <input name="l_r" type="text" class="form-control" id="l_r" value="<?php echo $rcek4['l_r']; ?>" readonly="readonly">
                  </div>
		  <label for="blower" class="col-sm-3 control-label">Blower</label>
          <div class="col-sm-3">
                    <input name="blower" type="text" class="form-control" id="blower" value="<?php echo $rcek4['blower']; ?>" readonly="readonly">
                  </div>	
        </div>
		<div class="form-group">
          <label for="rpm" class="col-sm-3 control-label">RPM</label>
          <div class="col-sm-3">
                    <input name="rpm" type="text" class="form-control" id="rpm" value="<?php echo $rcek4['rpm']; ?>" readonly="readonly">
                  </div>
		  <label for="plaiter" class="col-sm-3 control-label">Plaiter</label>
          <div class="col-sm-3">
                    <input name="plaiter" type="text" class="form-control" id="plaiter" value="<?php echo $rcek4['plaiter']; ?>" readonly="readonly">
                  </div>	
        </div>
		<div class="form-group">		  	
          <label for="cycle_time" class="col-sm-3 control-label">Cycle Time</label>
          <div class="col-sm-3">
                    <input name="cycle_time" type="text" class="form-control" id="cycle_time" value="<?php echo $rcek4['cycle_time']; ?>" readonly="readonly">
                  </div>
		  <label for="tempat_kain" class="col-sm-3 control-label">Proses NCP</label>
          <div class="col-sm-3">
                    <input name="tempat_kain" type="text" class="form-control" id="tempat_kain" value="<?php echo $rcekNM['tempat_kain'];?>" >
                  </div>	
        </div> 
		<div class="form-group">
		
        <!-- /.input group -->
      </div> 
		
		 
      </div>  		
	 	  <input type="hidden" value="<?php echo $cekNCP['id']; ?>" name="id">
		  <input type="hidden" value="<?php echo $rcek1['acc_keluar']; ?>" name="acc">
		  <input type="hidden" value="<?php echo $rcek['no_mesin']; ?>" name="mesin">
		
		  
 	</div>
	 
   	<div class="box-footer">
	<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Form-NCP'">Cancel <i class="fa fa-arrow-circle-o-left"></i></button>	
   <?php if($nokk!="" and $nokkNCP!="" and $NCPNO!=""){ ?>  
   			<?php if($cekNM>0){ ?>		
   <button type="submit" class="btn btn-primary pull-right" name="update" value="Ubah">Ubah <i class="fa fa-edit"></i></button> 
		<?php }else{?>
   <button type="submit" class="btn btn-info pull-right" name="save" value="Simpan">Simpan <i class="fa fa-save"></i></button>		
		<?php } ?>
   <?php } ?>
   
   </div>
    <!-- /.box-footer -->
 </div>
</form>
<div class="modal fade" id="DataKategoriMasalah">
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Kategori Masalah NCP</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="form-group">
                  <label for="kategori_masalah" class="col-md-3 control-label">Kategori</label>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="kategori_masalah" name="kategori_masalah" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>		    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<input type="submit" value="Simpan" name="simpan_kategori" id="simpan_kategori" class="btn btn-primary pull-right" >  
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>
<?php 
if($_POST['simpan_kategori']=="Simpan"){
	$kategoriM=strtoupper($_POST['kategori_masalah']);
	$sqlData1=mysqli_query($con,"INSERT INTO tbl_kategori_masalah_ncp SET 
		  kategori_masalah='".$kategoriM."',tgl_buat=now()");
	if($sqlData1){	
	echo "<script>swal({
  title: 'Data Telah Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
         window.location.href='index1.php?p=Form-NCP&manual=$manual&nokk=$nokk&nokkncp=$nokkNCP';
	 
  }
});</script>";
		}
}
?>
<?php
if($_POST['save']=="Simpan"){	
$jnskain1=str_replace("'","''",$_POST['jns_kain']);
$warna1=str_replace("'","''",$_POST['warna']);
$nowarna1=str_replace("'","''",$_POST['no_warna']);	
//$ket=str_replace("'","''",$_POST['ket']); 
	$sqlSimpan=mysqli_query($con,"INSERT INTO tbl_ncp_memo SET
	`jnsdata`='NCP',
	`nokk`='$nokk',
	`nokk_ncp`='$nokkNCP',
	`no_ncp`='$_POST[no_ncp]',
	`langganan`='$_POST[langganan]',
	`buyer`='$_POST[buyer]',
	`order`='$_POST[no_order]',
	`kategori_masalah`='$_POST[kategori_masalah]',
	`jenis_kain`='$jnskain1',
	`warna`='$warna1',
	`no_warna`='$nowarna1',
	`lot`='$_POST[lot]',
	`rol_induk`='$_POST[qty3]',
	`qty_induk`='$_POST[qty4]',
	`rol_ncp`='$_POST[jml_ncp]',
	`qty_ncp`='$_POST[qty_ncp]',
	`tolak_qcf`='$_POST[tolak]',
	`tgl_celup`='$_POST[tglcelup]',
	`mc_celup`='$_POST[no_mc]',
	`acc_keluar`='$_POST[acc_kain]',
	`operator`='$_POST[operator]',
	`masalah`='$_POST[masalah_ncp]',
	`masalah_dye`='$_POST[masalah_ncp_dye]',
	`tempat_kain`='$_POST[tempat_kain]',
	`tgl_buat`='$tglBuat',
	`tgl_update`=now(),
	`no_program`='$_POST[no_program]',
	`press_pump`='$_POST[press_pump]',
	`loading`='$_POST[loading]',
	`nozzle`='$_POST[nozzle]',
	`l_r`='$_POST[l_r]',
	`blower`='$_POST[blower]',
	`rpm`='$_POST[rpm]',
	`plaiter`='$_POST[plaiter]',
	`cycle_time`='$_POST[cycle_time]',
	`po_rajut`='$_POST[po_rajut]',
	`po_number`='$_POST[no_po]',
	`no_hanger`='$_POST[no_hanger]',
	`shift`='$_POST[shift1]',
	`ncp_hitung`='$_POST[ncp_hitung]',
	`id_ncp`='$_POST[id]'
	");
	
	$sqlDataQC=mysqli_query($cond,"UPDATE tbl_ncp_qcf_new SET 
	      ncp_in_dye='1'
		  WHERE id='$_POST[id]'");	
	
		if($sqlSimpan){	
	echo "<script>swal({
  title: 'Data Telah Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
        window.location.href='index1.php?p=Form-NCP&nokk=$nokk&manual=$manual&nokkncp=$nokkNCP';
	 
  }
});</script>";
		}

}

if($_POST['update']=="Ubah"){
	  $jnskain1=str_replace("'","''",$_POST['jns_kain']);
	  $warna1=str_replace("'","''",$_POST['warna']);
	  $nowarna1=str_replace("'","''",$_POST['no_warna']);
      //$ket=str_replace("'","''",$_POST['ket']);
	  if(isset($_POST["rmp_benang"]))  
        { 
            // Retrieving each selected option 
            foreach ($_POST['rmp_benang'] as $index => $subject1){
				   if($index>0){
					  $kt1=$kt1.",".$subject1; 
				   }else{
					   $kt1=$subject1;
				   }	
				    
			}
        }
	
  	
	$sqlUpdate=mysqli_query($con,"UPDATE tbl_ncp_memo SET	
	`langganan`='$_POST[langganan]',
	`buyer`='$_POST[buyer]',
	`order`='$_POST[no_order]',
	`jenis_kain`='$jnskain1',
	`warna`='$warna1',
	`no_warna`='$nowarna1',
	`lot`='$_POST[lot]',
	`rol_induk`='$_POST[qty3]',
	`qty_induk`='$_POST[qty4]',
	`rol_ncp`='$_POST[jml_ncp]',
	`qty_ncp`='$_POST[qty_ncp]',
	`tolak_qcf`='$_POST[tolak]',
	`tgl_celup`='$_POST[tglcelup]',
	`mc_celup`='$_POST[mesin]',
	`acc_keluar`='$_POST[acc_kain]',
	`operator`='$_POST[operator]',
	`masalah`='$_POST[masalah_ncp]',
	`masalah_dye`='$_POST[masalah_dye]',
	`tempat_kain`='$_POST[tempat_kain]',
	`no_program`='$_POST[no_program]',
	`press_pump`='$_POST[press_pump]',
	`loading`='$_POST[loading]',
	`nozzle`='$_POST[nozzle]',
	`l_r`='$_POST[l_r]',
	`blower`='$_POST[blower]',
	`rpm`='$_POST[rpm]',
	`plaiter`='$_POST[plaiter]',
	`cycle_time`='$_POST[cycle_time]',
	`po_rajut`='$_POST[po_rajut]',
	`po_number`='$_POST[no_po]',
	`no_hanger`='$_POST[no_hanger]',
	`shift`='$_POST[shift1]',
	`ncp_hitung`='$_POST[ncp_hitung]',
	`tgl_update`=now()
	WHERE `jnsdata`='NCP' and
	`nokk`='$nokk' and 
	`nokk_ncp`='$nokkNCP' and
	`no_ncp`='$_POST[no_ncp]'	
	");
	$sqlDataQC=mysqli_query($cond,"UPDATE tbl_ncp_qcf_new SET 
	      ncp_in_dye='1'
		  WHERE no_ncp_gabungan='$_POST[no_ncp]'");
	
		if($sqlUpdate){	
	echo "<script>swal({
  title: 'Data Telah diUbah',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
        window.location.href='index1.php?p=Form-NCP&nokk=$nokk&manual=$manual&nokkncp=$nokkNCP';	 
  }
});</script>";
		}
}
?>  
<script>
function aktif(){
		if(document.forms['form1']['manual'].value == "ya"){	
		document.form1.no_mc.removeAttribute("readonly");
		document.form1.no_mc.setAttribute("required",true);
		document.form1.nama_mc.removeAttribute("readonly");
		document.form1.nama_mc.setAttribute("required",true);	
		}
		else{
		document.form1.no_mc.setAttribute("readonly",true);
		document.form1.no_mc.removeAttribute("required");	
		document.form1.nama_mc.setAttribute("readonly",true);
		document.form1.nama_mc.removeAttribute("required");	
		}	   	
	}						
</script>            


