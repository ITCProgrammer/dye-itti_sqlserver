<script>
function aktif(){
		if(document.forms['form1']['kodesm'].value == ""){
		document.form1.waktu_mulai.setAttribute("disabled",true);
		document.form1.waktu_mulai.removeAttribute("required");
		document.form1.waktu_stop.setAttribute("disabled",true);
		document.form1.waktu_stop.removeAttribute("required");
		document.form1.datepicker.setAttribute("disabled",true);
		document.form1.datepicker.removeAttribute("required");	
		document.form1.datepicker3.setAttribute("disabled",true);
		document.form1.datepicker3.removeAttribute("required");						
		}
		else{
		document.form1.waktu_mulai.removeAttribute("disabled");
		document.form1.waktu_mulai.setAttribute("required",true);
		document.form1.waktu_stop.removeAttribute("disabled");
		document.form1.waktu_stop.setAttribute("required",true);	
		document.form1.datepicker.removeAttribute("disabled");
		document.form1.datepicker.setAttribute("required",true);
		document.form1.datepicker3.removeAttribute("disabled");
		document.form1.datepicker3.setAttribute("required",true);				
		}
	   	
	}
function aktif1(){
		if(document.forms['form1']['dyestuff'].value == "D"){
		document.form1.suhu_poly.removeAttribute("readonly");
		document.form1.suhu_poly.setAttribute("required",true);
		document.form1.ph_poly.removeAttribute("readonly");
		document.form1.ph_poly.setAttribute("required",true);/*
		document.form1.k_resep.removeAttribute("disabled");
		document.form1.k_resep.setAttribute("required",true);*/	
			
	   }else{  
		document.form1.suhu_poly.setAttribute("readonly",true);
		document.form1.suhu_poly.removeAttribute("required");
		document.form1.ph_poly.setAttribute("readonly",true);
		document.form1.ph_poly.removeAttribute("required"); 
		/*document.form1.k_resep.setAttribute("disabled",true);
		document.form1.k_resep.removeAttribute("required");  */ 
	   }
	}
function aktif2(){if((document.forms['form1']['sts'].value == "1" || document.forms['form1']['sts'].value == "5") && document.forms['form1']['sts_analisa'].value =="melebihi target"){
  	document.form1.analisa.removeAttribute("disabled");
  	document.form1.analisa.setAttribute("required",true);  
	document.form1.jml_topping.setAttribute("disabled",true);
	document.form1.jml_topping.removeAttribute("required");	
}else if(document.forms['form1']['sts'].value == "1" || document.forms['form1']['sts'].value == "5"){
	/*document.form1.k_resep.removeAttribute("disabled");
	document.form1.k_resep.setAttribute("required",true);*/
	document.form1.ket.removeAttribute("required");
	document.form1.jml_topping.setAttribute("disabled",true);
	document.form1.jml_topping.removeAttribute("required");
	document.form1.analisa.setAttribute("disabled",true);
	document.form1.analisa.removeAttribute("required");
}else if(document.forms['form1']['sts'].value == "2"){
  document.form1.jml_topping.removeAttribute("disabled");
  document.form1.jml_topping.setAttribute("required",true);
  document.form1.analisa.removeAttribute("disabled");
  document.form1.analisa.setAttribute("required",true);	
  /*document.form1.k_resep.setAttribute("disabled",true);
  document.form1.k_resep.removeAttribute("required");	*/			  
}else{
	document.form1.jml_topping.setAttribute("disabled",true);
	document.form1.jml_topping.removeAttribute("required");
	document.form1.analisa.setAttribute("disabled",true);
	document.form1.analisa.removeAttribute("required");
	/*document.form1.k_resep.setAttribute("disabled",true);
	document.form1.k_resep.removeAttribute("required");*/
	document.form1.ket.removeAttribute("required");
}
}	
function aktif3(){
	var str = document.forms['form1']['proses'].value;
		if( str.substr(0,10) == "Cuci Mesin"){
		document.form1.point_proses.setAttribute("disabled",true);
		document.form1.point_proses.removeAttribute("required");
	   }else{  
		document.form1.point_proses.removeAttribute("disabled");
		document.form1.point_proses.setAttribute("required",true);  		 
	   }
	}	
function aktif4(){
	var str = document.forms['form1']['gerobak'].value;
		if( str == ""){
		document.form1.jns_gerobak.setAttribute("disabled",true);
	   }else{  
		document.form1.jns_gerobak.removeAttribute("disabled");  		 
	   }
	}		
</script>
<?php
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
$nokk=$_GET['nokk'];
$nokkNCP=$_GET['nokkncp'];
$jd=$_GET['jd'];

$sqlCekNM=mysqli_query($con,"SELECT * FROM tbl_ncp_memo WHERE jnsdata='$jd' and nokk='$nokk' and nokk_ncp='$nokkNCP'");
$cekNM=mysqli_num_rows($sqlCekNM);
$rcekNM=mysqli_fetch_array($sqlCekNM);

$sqlCek=mysqli_query($con,"SELECT
	a.*,b.id as idm 
FROM
	tbl_schedule a
INNER JOIN tbl_montemp b ON a.id=b.id_schedule	
WHERE
	a.nokk = '$nokk' 
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
	 (`status` = 'sedang jalan' or `status` = 'antri mesin') and no_mesin='".$rcek['no_mesin']."' and no_urut='".$rcek['no_urut']."'
GROUP BY
	no_mesin,
	no_urut 
ORDER BY
	id ASC");
$cek2=mysqli_num_rows($sqlCek2);
$rcek2=mysqli_fetch_array($sqlCek2);
if($rcek2['ket_kartu']!=""){$ketsts=$rcek2['ket_kartu']."\n(".$rcek2['g_kk'].")";}else{$ketsts="";}
$sqlCek3=mysqli_query($con,"SELECT * FROM tbl_montemp WHERE nokk='$nokk' and (status='antri mesin' or status='sedang jalan') ORDER BY id DESC LIMIT 1");
$cek3=mysqli_num_rows($sqlCek3);
$rcek3=mysqli_fetch_array($sqlCek3);
$sqlCekAir=mysqli_query($con,"SELECT air_awal,waktu_tunggu FROM tbl_montemp WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
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
$sqlCek4=mysqli_query($con,"SELECT * FROM tbl_montemp WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
$cek4=mysqli_num_rows($sqlCek4);
$rcek4=mysqli_fetch_array($sqlCek4);
$sqlNCP=mysqli_query($cond,"SELECT * FROM tbl_ncp_qcf_new WHERE nokk='$nokkNCP' and dept='DYE' ORDER BY id DESC LIMIT 1");
$cekNCP=mysqli_fetch_array($sqlNCP);
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
                  <label for="no_po" class="col-sm-3 control-label">No KK Induk</label>
                  <div class="col-sm-4">
				  <input name="nokk" type="text" class="form-control" id="nokk" 
                     onchange="window.location='?p=Form-NCP&nokk='+this.value" value="<?php echo $_GET['nokk'];?>" placeholder="No KK" required >
		  </div>
			      <div class="col-sm-4">
				  <input name="id" type="hidden" class="form-control" id="id" value="<?php echo $rcek['idm'];?>" placeholder="ID">
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
                  <label for="no_po" class="col-sm-3 control-label">PO</label>
                  <div class="col-sm-5">
                    <input name="no_po" type="text" class="form-control" id="no_po" placeholder="PO" 
                    value="<?php if($cek>0){echo $rcek['po'];}else{if($r['PONumber']!=""){echo $r['PONumber'];}else if($nokk!=""){echo $cekM['no_po'];}} ?>" readonly="readonly" >
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="no_hanger" class="col-sm-3 control-label">No Hanger / No Item</label>
                  <div class="col-sm-3">
                    <input name="no_hanger" type="text" class="form-control" id="no_hanger" placeholder="No Hanger" 
                    value="<?php if($cek>0){echo $rcek['no_hanger'];}else{if($r['HangerNo']){echo $r['HangerNo'];}else if($nokk!=""){echo $cekM['no_item'];}}?>" readonly="readonly">  
                  </div>
				  <div class="col-sm-3">
				  <input name="no_item" type="text" class="form-control" id="no_item" placeholder="No Item" 
                    value="<?php if($rcek['no_item']!=""){echo $rcek['no_item'];}else if($r['ProductCode']!=""){echo $r['ProductCode'];}else{if($r['HangerNo']){echo $r['HangerNo'];}else if($nokk!=""){echo $cekM['no_item'];}}?>" readonly="readonly">
				  </div>	
        </div>
	    <div class="form-group">
                  <label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
                  <div class="col-sm-8">
					  <textarea name="jns_kain" readonly="readonly" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?php if($cek>0){echo $rcek['jenis_kain'];}else{if($r['ProductDesc']!=""){echo $r['ProductDesc'];}else if($nokk!=""){ echo $cekM['jenis_kain']; } }?></textarea>
		  </div>
        </div>
		<div class="form-group">
			  <label for="l_g" class="col-sm-3 control-label">Lebar X Gramasi </label>
			  <div class="col-sm-2">
				<input name="lebar" type="text" required class="form-control" id="lebar" placeholder="0" 
				value="<?php if($cek>0){echo $rcek['lebar'];}else{echo round($r['Lebar']);} ?>" readonly="readonly">
			  </div>
			  <div class="col-sm-2">
				<input name="grms" type="text" required class="form-control" id="grms" placeholder="0" 
				value="<?php if($cek>0){echo $rcek['gramasi'];}else{echo round($r['Gramasi']);} ?>" readonly="readonly">
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
		<div class="form-group">
                  <label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="qty1" type="text" required class="form-control" id="qty1" placeholder="0.00" 
                    value="<?php if($cek>0){echo $rcek['qty_order'];}else{echo round($r['BatchQuantity'],2);} ?>" readonly="readonly">
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
                    value="<?php if($cek>0){echo $rcek['lot'];}else{if($nomorLot!=""){echo $lotno;}else if($nokk!=""){echo $cekM['lot'];} } ?>" readonly="readonly" >
                  </div>
				  <label for="po_rajut" class="col-sm-3 control-label">PO Rajut</label>
                  <div class="col-sm-3">
                    <input name="po_rajut" type="text" class="form-control" id="po_rajut" placeholder="PO Rajut" 
                    value="<?php echo $cekNCP['po_rajut'];?>" readonly="readonly" >
                  </div>
        </div>
		 
		
	  </div>
	  		<!-- col --> 
	  <div class="col-md-6">
		  <div class="form-group">
		  <label for="jnsdata" class="col-sm-3 control-label">Jenis Data</label>
          <div class="col-sm-2">
			  		<select name="jnsdata" class="form-control" onchange="window.location='?p=Form-NCP&nokk=<?php echo $_GET['nokk'];?>&jd='+this.value">
						<option value="">Pilih</option>
						<option value="NCP" <?php if($_GET['jd']=="NCP"){ echo "SELECTED";} ?>>NCP</option>
						<!--<option value="Memo" <?php if($_GET['jd']=="Memo"){ echo "SELECTED";} ?>>Memo</option>-->
			  		</select>	
                  </div>	  
          <label for="nokk_ncp" class="col-sm-1 control-label">KK NCP</label>
          <div class="col-sm-2">
                    <input name="nokk_ncp" type="text" class="form-control" id="nokk_ncp" 
                    onchange="window.location='?p=Form-NCP&nokk=<?php echo $_GET['nokk'];?>&jd=<?php echo $_GET['jd'];?>&nokkncp='+this.value" value="<?php echo $_GET['nokkncp'];?>">
                  </div>
		  <label for="no_ncp" class="col-sm-1 control-label">No NCP</label>
          <div class="col-sm-3">
                    <input name="no_ncp" type="text" class="form-control" id="no_ncp" value="<?php echo $cekNCP['no_ncp_gabungan'];?>" readonly="readonly">
                  </div>
        </div>
		<div class="form-group">
          <label for="masalah_ncp" class="col-sm-3 control-label">Masalah NCP</label>
          <div class="col-sm-9">
                    <input name="masalah_ncp" type="text" class="form-control" id="masalah_ncp" value="<?php echo $cekNCP['masalah'];?>" readonly="readonly">
                  </div>				   
        </div>  
		<div class="form-group">
			  <label for="jml_bruto" class="col-sm-3 control-label">Roll Induk</label>
			  <div class="col-sm-3">
				<input name="qty3" type="text" required class="form-control" id="qty3" placeholder="0.00" 
				value="<?php echo $rcek4['rol']; ?>" >
			  </div>
			  <label for="jml_ncp" class="col-sm-3 control-label">Roll NCP</label>
			  <div class="col-sm-3">
				<input name="jml_ncp" type="text" required class="form-control" id="jml_ncp" placeholder="0.00" 
				value="<?php echo $cekNCP['rol'];?>" readonly="readonly">
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
				value="<?php echo $cekNCP['berat'];?>" readonly="readonly">
				<span class="input-group-addon">KGs</span>
				</div>	
			  </div>	
		</div>  
		<?php if($cek>0 and ($rcek['kapasitas']!="" and $rcek['kapasitas']!="0")){$loading=round($rcek['bruto']/$rcek['kapasitas'],4)*100;}else{if($r['Weight']!="" and ($rcek['kapasitas']!="" and $rcek['kapasitas']!="0")){$loading=round($r['Weight']/$rcek['kapasitas'],4)*100;}else if($nokk!="" and ($rcek['kapasitas']!="" and $rcek['kapasitas']!="0")){$loading=round($cekM['bruto']/$rcek['kapasitas'],4)*100;}} ?>  
		<div class="form-group">
                  <label for="no_mc" class="col-sm-3 control-label">No MC</label>
                  <div class="col-sm-3">					  	  	
						  <select name="no_mc" disabled="disabled" class="form-control">
							  	<option value="">Pilih</option>
							  <?php 
							  $sqlKap=mysqli_query($con,"SELECT no_mesin FROM tbl_mesin WHERE kapasitas='$rcek[kapasitas]' ORDER BY no_mesin ASC");
							  while($rK=mysqli_fetch_array($sqlKap)){
							  ?>
						    <option value="<?php echo $rK['no_mesin']; ?>" <?php if($rcek['no_mesin']==$rK['no_mesin']){ echo "SELECTED"; }?> ><?php echo $rK['no_mesin']; ?></option>
							 <?php } ?>	  
					  </select>
				  </div>
          <label for="qty_persen" class="col-sm-3 control-label">Qty</label>
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
          <div class="col-sm-2">
                    <input name="tolak" type="text" class="form-control" id="tolak" value="" >
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
		  <label for="tempat_kain" class="col-sm-3 control-label">Tempat Kain</label>
          <div class="col-sm-3">
                    <input name="tempat_kain" type="text" class="form-control" id="tempat_kain" value="<?php echo $rcekNM['tempat_kain'];?>" >
                  </div>	
        </div>  
		<fieldset>
		<legend>Tindakan Penyelesaian <input type="checkbox" value="1" name="cektp"></legend> 
		<div class="form-group">
        <label for="tgl_rencana" class="col-sm-3 control-label">Tgl. Rencana Penyelesaian</label>
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl_rencana" type="text" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="<?php echo $cekNCP['tgl_rencana']; ?>" autocomplete="off" disabled="disabled"/>
          </div>
        </div>
		<label for="tgl_kembali_qcf" class="col-sm-3 control-label">Tgl. Kembali Ke QCF</label>
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl_kembali_qcf" type="text" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php echo $cekNCP['tgl_kembali_qcf']; ?>" autocomplete="off"/>
          </div>
        </div>	
	  </div>	 
	  <div class="form-group">
		<label for="multi" class="col-sm-3 control-label">Rincian</label>
			<div class="col-sm-4">
                	<select class="form-control select2" multiple="multiple" data-placeholder="Jenis Masalah" name="rmp_benang[]" id="kerusakan">
					<?php
					$conn=mysqli_connect("10.0.0.10","dit","4dm1n","db_qc");  
					$dtArr=trim($cekNCP['penyelesaian']);	
					$data = explode(",",$dtArr);
					$qCek1=mysqli_query($conn,"SELECT nama FROM tbl_masalah_ncp WHERE jenis='Penyelesaian' ORDER BY nama ASC");
					$i=0;	
					while($dCek1=mysqli_fetch_array($qCek1)){ ?>
					<option value="<?php echo $dCek1['nama'];?>" <?php if($dCek1['nama']==$data[0] or $dCek1['nama']==$data[1] or $dCek1['nama']==$data[2] or $dCek1['nama']==$data[3] or $dCek1['nama']==$data[4] or $dCek1['nama']==$data[5]){echo "SELECTED";} ?>><?php echo $dCek1['nama'];?></option>
					<?php $i++;} ?>                 
					</select>				
			</div>  
		<label for="rincian" class="col-sm-2 control-label">Penyelesaian</label>		  
			<div class="col-sm-3">
				<select class="form-control select2" name="rincian">
					<option value="">Pilih</option>
					<option value="Celup Ulang" <?php if($cekNCP['rincian']=="Celup Ulang"){echo "SELECTED";}?>>Celup Ulang</option>
					<option value="Tidak Celup Ulang" <?php if($cekNCP['rincian']=="Tidak Celup Ulang"){echo "SELECTED";}?>>Tidak Celup Ulang</option>
					<option value="Upgrade" <?php if($cekNCP['rincian']=="Upgrade"){echo "SELECTED";}?>>Upgrade</option>
					<option value="Disposisi" <?php if($cekNCP['rincian']=="Disposisi"){echo "SELECTED";}?>>Disposisi</option>
					<option value="BS" <?php if($cekNCP['rincian']=="BS"){echo "SELECTED";}?>>BS</option>
					<option value="Tunggu Conform" <?php if($cekNCP['rincian']=="Tunggu Conform"){echo "SELECTED";}?>>Tunggu Conform</option>
				</select>	
			</div>		  
	</div> 
		<div class="form-group">
        <label for="penanggung_jawab" class="col-sm-3 control-label">Penanggung Jawab</label>
        <div class="col-sm-4"> 
		<select class="form-control select2" name="penanggung_jawab" id="penanggung_jawab">
			<option value="">Pilih</option>
				<?php 
					$qrytj=mysqli_query($conn,"SELECT nama FROM tbl_tjawab_ncp ORDER BY nama ASC");
					while($rtj=mysqli_fetch_array($qrytj)){
				?>
				<option value="<?php echo $rtj['nama'];?>" <?php if($cekNCP['penanggung_jawab']==$rtj['nama']){echo "SELECTED";}?>><?php echo $rtj['nama'];?></option>	
				<?php }?>
		</select>
			</div>
		<label for="shift" class="col-sm-2 control-label">Shift</label>
        <div class="col-sm-2">  
		<select class="form-control" name="shift">
			<option value="">Pilih</option>
			<option value="A" <?php if($cekNCP['shift']=="A"){echo "SELECTED"; } ?>>A</option>
			<option value="B" <?php if($cekNCP['shift']=="B"){echo "SELECTED"; } ?>>B</option>
			<option value="C" <?php if($cekNCP['shift']=="C"){echo "SELECTED"; } ?>>C</option>
			<option value="Non-Shift" <?php if($cekNCP['shift']=="Non-Shift"){echo "SELECTED"; } ?>>Non-Shift</option>
		</select>		
        </div>	
		</div>
		<div class="form-group">
		<label for="perbaikan" class="col-sm-3 control-label">Perbaikan</label>
        <div class="col-sm-4">  
			<input name="perbaikan" type="text" class="form-control" id="perbaikan" value="<?php echo $cekNCP['perbaikan']; ?>" placeholder="Nama Staff">			
        </div>	
        <label for="penyebab" class="col-sm-2 control-label">Penyebab</label>
        <div class="col-sm-2">  
		<input name="penyebab" type="text" class="form-control" id="penyebab" value="DYE" readonly>			
        </div>
	    </div>	
		<div class="form-group">
          <label for="ket" class="col-sm-3 control-label">Keterangan</label>
          <div class="col-sm-9">
			 		<textarea name="ket" rows="3" class="form-control" id="ket" placeholder="Keterangan"><?php echo $cekNCP['ket_penyelesaian']; ?></textarea> 
                  </div>		  
        </div>	
		</fieldset>
		 
      </div>  		
	 	  <input type="hidden" value="<?php echo $cekNCP['id']; ?>" name="id">
		  <input type="hidden" value="<?php echo $rcek1['acc_keluar']; ?>" name="acc">
		  <input type="hidden" value="<?php echo $rcek['no_mesin']; ?>" name="mesin">
		
		  
 	</div>
   	<div class="box-footer">
	<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Form-NCP'">Cancel <i class="fa fa-arrow-circle-o-left"></i></button>	
   <?php if($nokk!="" and $nokkNCP!=""){ ?>  
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
<?php
if($_POST['save']=="Simpan"){	
$jnskain1=str_replace("'","''",$_POST['jns_kain']);
$warna1=str_replace("'","''",$_POST['warna']);
$nowarna1=str_replace("'","''",$_POST['no_warna']);	
$ket=str_replace("'","''",$_POST['ket']);
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
	/*if($_POST['tgl_rencana']!=""){$tglRC=" tgl_rencana='".$_POST['tgl_rencana']."', ";}else{$tglRC=" tgl_rencana=null, ";}*/
	if($_POST['tgl_kembali_qcf']!=""){$tglKQC=" tgl_kembali_qcf='".$_POST['tgl_kembali_qcf']."', ";}else{$tglKQC=" tgl_kembali_qcf=null, ";}
	/*if($rcek['tgl_terima']!=""){$tglTrima=" "; }else{$tglTrima=" tgl_terima=now(), ";}*/
	
	if($jd=="NCP"){
  	  $sqlData=mysqli_query($conn,"UPDATE tbl_ncp_qcf_new SET 
	      $tglKQC
		  penyelesaian='$kt1',
		  acc='".$_POST['acc']."',
		  mesin='".$_POST['mesin']."',
		  shift='".$_POST['shift']."',
		  penyebab='".$_POST['penyebab']."',
		  perbaikan='".$_POST['perbaikan']."',
		  penanggung_jawab='".$_POST['penanggung_jawab']."',
		  rincian='".$_POST['rincian']."',
		  ket_penyelesaian='$ket'
		  WHERE id='".$_POST['id']."'");	 	  
	}
	$sqlSimpan=mysqli_query($con,"INSERT INTO tbl_ncp_memo SET
	`jnsdata`='$jd',
	`nokk`='$nokk',
	`nokk_ncp`='$nokkNCP',
	`no_ncp`='$_POST[no_ncp]',
	`langganan`='$_POST[langganan]',
	`buyer`='$_POST[buyer]',
	`order`='$_POST[no_order]',
	`jenis_kain`='$jnskain1',
	`warna`='$warna1',
	`no_warna`='$nowarna1',
	`lot`='$_POST[lot]',
	`rol_induk`='',
	`qty_induk`='',
	`rol_ncp`='',
	`qty_ncp`='',
	`tolak_qcf`='',
	`tgl_celup`='',
	`mc_celup`='',
	`acc_keluar`='',
	`operator`='',
	`masalah`='',
	`tempat_kain`='',
	`tgl_penyelesaian`='',
	`acc_perbaikan`='',
	`penyelesaian`='',
	`tgl_buat`=now(),
	`tgl_update`=now()
	");
		if($sqlSimpan){	
	echo "<script>swal({
  title: 'Data Telah Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
        window.location.href='index1.php?p=Form-NCP&nokk=$nokk&jd=$jd&nokkncp=$nokkNCP';
	 
  }
});</script>";
		}

}

if($_POST['update']=="Ubah"){
	  $jnskain1=str_replace("'","''",$_POST['jns_kain']);
	  $warna1=str_replace("'","''",$_POST['warna']);
	  $nowarna1=str_replace("'","''",$_POST['no_warna']);
      $ket=str_replace("'","''",$_POST['ket']);
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
	/*if($_POST['tgl_rencana']!=""){$tglRC=" tgl_rencana='".$_POST['tgl_rencana']."', ";}else{$tglRC=" tgl_rencana=null, ";}*/
	if($_POST['tgl_kembali_qcf']!=""){$tglKQC=" tgl_kembali_qcf='".$_POST['tgl_kembali_qcf']."', ";}else{$tglKQC=" tgl_kembali_qcf=null, ";}
	/*if($rcek['tgl_terima']!=""){$tglTrima=" "; }else{$tglTrima=" tgl_terima=now(), ";}*/
  	if($jd=="NCP"){  
	$sqlData=mysqli_query($conn,"UPDATE tbl_ncp_qcf_new SET 
	      $tglKQC
		  penyelesaian='$kt1',
		  acc='".$_POST['acc']."',
		  mesin='".$_POST['mesin']."',
		  shift='".$_POST['shift']."',
		  penyebab='".$_POST['penyebab']."',
		  perbaikan='".$_POST['perbaikan']."',
		  penanggung_jawab='".$_POST['penanggung_jawab']."',
		  rincian='".$_POST['rincian']."',
		  ket_penyelesaian='$ket'
		  WHERE id='".$_POST['id']."'");	 	  
	}
	$sqlUpdate=mysqli_query($con,"UPDATE tbl_ncp_memo SET
	`no_ncp`='$_POST[no_ncp]',
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
	`tempat_kain`='$_POST[tempat_kain]',
	`tgl_penyelesaian`='$_POST[tgl_kembali_qcf]',
	`acc_perbaikan`='$_POST[penanggung_jawab]',
	`penyelesaian`='$_POST[rincian]',
	`tgl_update`=now()
	WHERE `jnsdata`='$jd' and
	`nokk`='$nokk' and 
	`nokk_ncp`='$nokkNCP'
	");
	
		if($sqlUpdate){	
	echo "<script>swal({
  title: 'Data Telah diUbah',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
        window.location.href='index1.php?p=Form-NCP&nokk=$nokk&jd=$jd&nokkncp=$nokkNCP';
	 
  }
});</script>";
		}
}
?>  
						
                    


