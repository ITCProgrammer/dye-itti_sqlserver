<?php
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
$nokk=$_GET['nokk'];
$TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
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
$qryCek =mysqli_query($con,"SELECT * FROM tbl_hasilcelup WHERE nokk='$nokk' ORDER BY id DESC Limit 1");
$rdata=mysqli_fetch_array($qryCek);
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
                     onchange="window.location='?p=Form-Masalah-Celup&nokk='+this.value" value="<?php echo $_GET['nokk'];?>" placeholder="No KK" required >
		  </div>
			      <div class="col-sm-4">
				  <input name="id" type="hidden" class="form-control" id="id" value="<?php echo $rcek['idm'];?>" placeholder="ID">
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
        <label for="tgl_delivery" class="col-sm-3 control-label">Tgl. Delivery</label>
        <div class="col-sm-4">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl_delivery" type="text" disabled="disabled" required class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php if($cek>0){echo $rcek['tgl_delivery'];}else{if($r['RequiredDate']!=""){echo date('Y-m-d', strtotime($r['RequiredDate']));}}?>"/>
          </div>
        </div>
	  </div>
		<div class="form-group">
			  <label for="l_g" class="col-sm-3 control-label">L X Grm Permintaan</label>
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
        </div>
		<div class="form-group">
			  <label for="jml_bruto" class="col-sm-3 control-label">Rol &amp; Qty</label>
			  <div class="col-sm-2">
				<input name="qty3" type="text" required class="form-control" id="qty3" placeholder="0.00" 
				value="<?php if($cek2>0){echo $rcek2['rol'].$rcek2['kk'];}else{if($r['RollCount']!=""){echo round($r['RollCount']);}else if($nokk!=""){echo $cekM['jml_roll'];}} ?>" readonly="readonly">
			  </div>
			  <div class="col-sm-3">
				<div class="input-group">  
				<input name="qty4" type="text" required class="form-control" id="qty4" placeholder="0.00" style="text-align: right;" 
				value="<?php if($cek2>0){echo $rcek2['bruto'];}else{if($r['Weight']!=""){echo round($r['Weight'],2);}else if($nokk!=""){echo $cekM['bruto'];}} ?>" readonly="readonly">
				<span class="input-group-addon">KGs</span>
				</div>	
			  </div>		
		</div>
	  		  
		<div class="form-group">
                  <label for="kapasitas" class="col-sm-3 control-label">Kapasitas Mesin</label>
                  <div class="col-sm-3">
			  	    <select name="kapasitas" disabled="disabled" class="form-control">
							  <option value="">Pilih</option>
							  <option value="<?php echo $rK['kapasitas']; ?>" <?php if($rcek['kapasitas']==$rK['kapasitas']){ echo "SELECTED"; }?>><?php echo $rK['kapasitas']; ?> KGs</option>
					  </select>					  
				  </div>
					  
	    </div>
		 
		<div class="form-group">
                  <label for="no_mc" class="col-sm-3 control-label">No MC</label>
                  <div class="col-sm-2">					  
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
					  
		</div> 
		<div class="form-group">
          <label for="rcode1" class="col-sm-3 control-label">Rcode</label>
          <div class="col-sm-3">
                    <input name="rcode1" type="text" disabled="disabled" class="form-control" id="rcode1" 
                    value="<?php echo $rdata['rcode']; ?>">
                  </div>				   
        </div> 
		<div class="form-group">
                  <label for="sts" class="col-sm-3 control-label">Status</label>
                  <div class="col-sm-5">					  
						  <select name="sts" required disabled="disabled" class="form-control" id="sts">
							  	<option value="">Pilih</option>
							  	<option value="1" <?php if($rdata['status']=="OK"){ echo "SELECTED";} ?>>OK</option>
							    <option value="5" <?php if($rdata['status']=="Celup Poly Dulu-Matching"){ echo "SELECTED";} ?>>Celup Poly Dulu-Matching</option>
							    <option value="2" <?php if($rdata['status']=="Gagal Proses"){ echo "SELECTED";} ?>>Gagal Proses</option>
							  	<option value="3" <?php if($rdata['status']=="Levelling-Matching"){ echo "SELECTED";} ?>>Levelling-Matching</option>
							  	<option value="4" <?php if($rdata['status']=="Pelunturan-Matching"){ echo "SELECTED";} ?>>Pelunturan-Matching</option>
							  	<option value="6" <?php if($rdata['status']=="Scouring Turun"){ echo "SELECTED";} ?>>Scouring Turun</option>
							  	<option value="7" <?php if($rdata['status']=="Continuous - Bleaching"){ echo "SELECTED";} ?>>Continuous - Bleaching</option>
							  	<option value="8" <?php if($rdata['status']=="Relaxing - Priset"){ echo "SELECTED";} ?>>Relaxing - Priset</option>
					  </select>
				  </div>
				 <div class="col-sm-3">					  
						  <select name="jml_topping" class="form-control" id="jml_topping" required disabled>
							    <option value="">Jml Topping</option>  
							    <option value="-">-</option>
							  	<option value="0x" <?php if($rdata['jml_topping']=="0x"){ echo "SELECTED";}?>>0x</option>				
							  	<option value="1x" <?php if($rdata['jml_topping']=="1x"){ echo "SELECTED";}?>>1x</option>
							    <option value="2x" <?php if($rdata['jml_topping']=="2x"){ echo "SELECTED";}?>>2x</option>
							  	<option value="3x" <?php if($rdata['jml_topping']=="3x"){ echo "SELECTED";}?>>3x</option>
							    <option value="4x" <?php if($rdata['jml_topping']=="4x"){ echo "SELECTED";}?>>4x</option>
							  	<option value="5x" <?php if($rdata['jml_topping']=="5x"){ echo "SELECTED";}?>>5x</option>
							  	<option value="6x" <?php if($rdata['jml_topping']=="6x"){ echo "SELECTED";}?>>6x</option>
							    <option value="7x" <?php if($rdata['jml_topping']=="7x"){ echo "SELECTED";}?>>7x</option>
							  	<option value="8x" <?php if($rdata['jml_topping']=="8x"){ echo "SELECTED";}?>>8x</option>
							    <option value="9x" <?php if($rdata['jml_topping']=="9x"){ echo "SELECTED";}?>>9x</option>
							  	<option value="10x" <?php if($rdata['jml_topping']=="10x"){ echo "SELECTED";}?>>10x</option>
					  </select>
				  </div>	
					  
		</div>  
		<div class="form-group">
                  <label for="shift" class="col-sm-3 control-label">Shift</label>
                  <div class="col-sm-2">					  
						  <select name="shift" required disabled="disabled" class="form-control">
							  	<option value="">Pilih</option>
							  	<option value="1" <?php if($rdata['shift']=="1"){ echo "SELECTED"; }?>>1</option>
							    <option value="2" <?php if($rdata['shift']=="2"){ echo "SELECTED"; }?>>2</option>
							  	<option value="3" <?php if($rdata['shift']=="3"){ echo "SELECTED"; }?>>3</option>
					  </select>
				  </div>
					  
		</div>
		<div class="form-group">
                  <label for="g_shift" class="col-sm-3 control-label">Group Shift</label>
                  <div class="col-sm-2">					  
						  <select name="g_shift" required disabled="disabled" class="form-control">
							  	<option value="">Pilih</option>
							  	<option value="A" <?php if($rdata['g_shift']=="A"){ echo "SELECTED"; }?>>A</option>
							    <option value="B" <?php if($rdata['g_shift']=="B"){ echo "SELECTED"; }?>>B</option>
							  	<option value="C" <?php if($rdata['g_shift']=="C"){ echo "SELECTED"; }?>>C</option>
					  </select>
				  </div>
					  
		</div>
		  
	  </div>
	  		<!-- col --> 
	  <div class="col-md-6">
		<div class="form-group">
                  <label for="kodesm" class="col-sm-3 control-label">Kode Stop Mesin</label>
                  <div class="col-sm-2">					  
						  <select name="kodesm" disabled="disabled" class="form-control" id="kodesm" onChange="aktif();">
							  	<option value="">Pilih</option>
							  	<option value="LM">LM</option>
							  	<option value="KM">KM</option>
							  	<option value="PT">PT</option>
							  	<option value="KO">KO</option>
							  	<option value="AP">AP</option>
							  	<option value="PA">PA</option>
							  	<option value="PM">PM</option>
							  	<option value="GT">GT</option>
							  	<option value="TG">TG</option>
							  	<option value="OK">OK</option>							  	
				      </select>
				  </div>
					  
		</div>  
		<div class="form-group">
                  <label for="mulaism" class="col-sm-3 control-label">Mulai Stop Mesin</label>
			      <div class="col-sm-3">
				  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="waktu_mulai" id="waktu_mulai" placeholder="00:00" disabled>					  
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                   </div>
                  </div>
			</div>	  
                  <div class="col-sm-4">					  
						  <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="mulaism" type="text" class="form-control pull-right" id="datepicker3" placeholder="0000-00-00" value="" disabled/>
          </div>
				  </div>
					  
		</div>		 
		<div class="form-group">
                  <label for="selesaism" class="col-sm-3 control-label">Selesai Stop Mesin</label>
			      <div class="col-sm-3">
				  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="waktu_stop" placeholder="00:00" disabled>
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
			</div>
                  <div class="col-sm-4">					  
						  <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="selesaism" type="text" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="" disabled/>
          </div>
				  </div>
					  
		</div>  
		<div class="form-group">
                  <label for="proses" class="col-sm-3 control-label">Aktual Proses</label>
                  <div class="col-sm-5">					  
					<input type="text" name="proses" value="<?php echo $rdata['proses']; ?>" disabled="disabled" class="form-control">
				  </div>
		  </div>
		<div class="form-group">
                  <label for="point_proses" class="col-sm-3 control-label">Point Proses</label>
                  <div class="col-sm-5">					  
						  <input type="text" name="point_proses" value="<?php echo $rdata['proses_point']; ?>" disabled="disabled" class="form-control">
				  </div>
		  </div>  
		<div class="form-group" hidden="">
                  <label for="point" class="col-sm-3 control-label">Point</label>
                  <div class="col-sm-2">					  
				    <input type="text" name="point" value="<?php echo $rdata['point']; ?>" disabled="disabled" class="form-control">
				  </div>
					  
		</div>
		<div class="form-group">
                  <label for="k_resep" class="col-sm-3 control-label">Kestabilan Resep</label>
                  <div class="col-sm-2">					  
						  <input type="text" name="k_resep" value="<?php echo $rdata['k_resep']; ?>" disabled="disabled" class="form-control">
				  </div>
					  
		</div>   
		<div class="form-group">
          <label for="acc_keluar" class="col-sm-3 control-label">Acc Keluar Kain </label>
                  <div class="col-sm-5">					  
				    <input type="text" name="acc_keluar" value="<?php echo $rdata['acc_keluar']; ?>" disabled="disabled" class="form-control">
				  </div>
					  
	    </div>
		<div class="form-group">
          <label for="operator" class="col-sm-3 control-label">Operator Keluar Kain </label>
                  <div class="col-sm-5">					  
				    <input type="text" name="operator" value="<?php echo $rdata['operator_keluar']; ?>" disabled="disabled" class="form-control">
				  </div>
					  
	    </div>
		<div class="form-group hidden">
                  <label for="operator_potong" class="col-sm-3 control-label">Operator Potong Celup</label>
                  <div class="col-sm-5">					  
						  <input type="text" name="operator_potong" value="<?php echo $rdata['operator_potong']; ?>" disabled="disabled" class="form-control">
				  </div>
					  
		    </div>  
		<div class="form-group">
          <label for="a_dingin" class="col-sm-3 control-label">pH &amp; Suhu Tes Cuci Bulu</label>
          <div class="col-sm-2">
                    <input name="ph_cb" type="text" disabled="disabled" class="form-control" id="ph_cb" placeholder="0" style="text-align: right;" 
                    value="">
                  </div>
		  <div class="col-sm-2">
					<div class="input-group">  
                    <input name="suhu_cb" type="text" disabled="disabled" class="form-control" id="suhu_cb" placeholder="0" style="text-align: right;" 
                    value="">
					<span class="input-group-addon">&deg;</span></div>  
                  </div>	  
        </div> 		
		<div class="form-group">
          <label for="a_dingin" class="col-sm-3 control-label">pH &amp; Suhu Tes Poly</label>
          <div class="col-sm-2">
                    <input name="ph_poly" type="text" disabled="disabled" class="form-control" id="ph_poly" placeholder="0" style="text-align: right;" 
                    value="" >
                  </div>
		  <div class="col-sm-2">
					<div class="input-group">  
                    <input name="suhu_poly" type="text" disabled="disabled" class="form-control" id="suhu_poly" placeholder="0" style="text-align: right" 
                    value="">
					<span class="input-group-addon">&deg;</span></div>  
                  </div> 	
        </div> 		
		<div class="form-group">
          <label for="a_dingin" class="col-sm-3 control-label">pH &amp; Suhu Tes Cotton</label>
          <div class="col-sm-2">
                    <input name="ph_cott" type="text" disabled="disabled" class="form-control" id="ph_cott" placeholder="0" style="text-align: right;" 
                    value="">
                  </div>
		  <div class="col-sm-2">
					<div class="input-group">  
                    <input name="suhu_cott" type="text" disabled="disabled" class="form-control" id="suhu_cott" placeholder="0" style="text-align: right" 
                    value="">
					<span class="input-group-addon">&deg;</span></div> 
                  </div>	
        </div>
		<div class="form-group">
          <label for="a_dingin" class="col-sm-3 control-label">Berat Jenis</label>
          <div class="col-sm-2">
                    <input name="berat_jns" type="text" disabled="disabled" class="form-control" id="berat_jns" placeholder="0" style="text-align: right;" 
                    value="" >
                  </div>				   
        </div>
		<div class="form-group">
          <label for="a_dingin" class="col-sm-3 control-label">pH Na<sub>2</sub>CO<sub>3</sub></label>
          <div class="col-sm-2">
                    <input name="ph_naco" type="text" disabled="disabled" class="form-control" id="ph_naco" placeholder="0" style="text-align: right;" 
                    value="">
                  </div>				   
        </div>		
		<div class="form-group">
          <label for="a_dingin" class="col-sm-3 control-label">Lama Proses</label>
          <div class="col-sm-3">
					<div class="input-group">  
                    <input name="lama_proses" type="text" disabled="disabled" class="form-control" id="lama_proses" placeholder="HH:MM" 
                    value="<?php if($nokk!=""){echo $rdata['lama_proses'];}?>" readonly="readonly">
					<div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                   </div>
					  </div>	
          </div>				   
        </div> 		  
		<div class="form-group">
                  <label for="ket" class="col-sm-3 control-label">Keterangan</label>
                  <div class="col-sm-8">					  
						  <textarea name="ket" disabled="disabled" class="form-control"><?php echo $rdata['ket'];?></textarea>
				  </div>
					  
		</div>  
        <div class="form-group">
                  <label for="inspektor" class="col-sm-3 control-label">Inspektor</label>
                  <div class="col-sm-6">
                  <input name="inspektor" type="text" class="form-control" id="inspektor" placeholder="inspektor" value="" required>
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="masalah" class="col-sm-3 control-label">Masalah</label>
                  <div class="col-sm-8">
                  <input name="masalah" type="text" class="form-control" id="masalah" placeholder="masalah" value="" required>
                  </div>				   
        </div>
		<div class="form-group">
                  <label for="perbaikan" class="col-sm-3 control-label">Tindakan Perbaikan</label>
                  <div class="col-sm-8">
                  <input name="perbaikan" type="text" class="form-control" id="perbaikan" placeholder="perbaikan" value="" required>
                  </div>				   
        </div>  
		
	</div>  		
	 	  <input type="hidden" value="<?php echo $rdata['id'];?>" name="idhs">
		
		  
 	</div>
   	<div class="box-footer">
	<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Masalah-Celupan'">Kembali <i class="fa fa-arrow-circle-o-left"></i></button>	
   <?php if($cek1111>0){ ?>
   <?php }else{ ?>	   
   <button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button> 
   <?php } ?>
   
   </div>
    <!-- /.box-footer -->
 </div>
</form>
<?php 
if($_POST['save']=="save"){	
$qrySimpan= mysqli_query($con,"INSERT INTO tbl_masalah_celupan SET
`id_hasilcelup`='$_POST[idhs]',
`inspektor`='$_POST[inspektor]',
`masalah`='$_POST[masalah]',
`tidakan_perbaikan`='$_POST[perbaikan]',
`tgl_buat`=now(),
`tgl_update`=now()");
	if($qrySimpan){
echo "<script>swal({
  title: 'Data Telah DiSimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    
	 window.location.href='?p=Masalah-Celupan'; 
  }
});</script>";
	}
}
?>
