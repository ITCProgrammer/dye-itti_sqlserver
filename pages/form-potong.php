<?php
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
$nokk=$_GET['nokk'];
// $sql=sqlsrv_query($conn,"select top 1
// 			x.*,dbo.fn_StockMovementDetails_GetTotalWeightPCC(0, x.PCBID) as Weight, 
// 			pm.Weight as Gramasi,pm.CuttableWidth as Lebar, pm.Description as ProductDesc, pm.ColorNo, pm.Color,
//       dbo.fn_StockMovementDetails_GetTotalRollPCC(0, x.PCBID) as RollCount
// 		from
// 			(
// 			select
// 				so.SONumber, convert(char(10),so.SODate,103) as TglSO, so.CustomerID, so.BuyerID, so.PODate,
// 				sod.ID as SODID, sod.ProductID, sod.Quantity, sod.UnitID, sod.WeightUnitID, 
// 				soda.RefNo as DetailRefNo,jo.DocumentNo as NoOrder,soda.PONumber,
// 				pcb.ID as PCBID, pcb.Gross as Bruto,soda.HangerNo,
// 				pcb.Quantity as BatchQuantity, pcb.UnitID as BatchUnitID, pcb.ScheduledDate, pcb.ProductionScheduledDate,
// 				pcblp.DepartmentID,pcb.LotNo,pcb.PCID,pcb.ChildLevel,pcb.RootID,sod.RequiredDate
				
// 			from
// 				SalesOrders so inner join
// 				JobOrders jo on jo.SOID=so.ID inner join
// 				SODetails sod on so.ID = sod.SOID inner join
// 				SODetailsAdditional soda on sod.ID = soda.SODID left join
// 				ProcessControlJO pcjo on sod.ID = pcjo.SODID left join
// 				ProcessControlBatches pcb on pcjo.PCID = pcb.PCID left join
// 				ProcessControlBatchesLastPosition pcblp on pcb.ID = pcblp.PCBID left join
// 				ProcessFlowProcessNo pfpn on pfpn.EntryType = 2 and pcb.ID = pfpn.ParentID and pfpn.MachineType = 24 left join
// 				ProcessFlowDetailsNote pfdn on pfpn.EntryType = pfdn.EntryType and pfpn.ID = pfdn.ParentID
// 			where pcb.DocumentNo='$nokk' and pcb.Gross<>'0'
// 				group by
// 					so.SONumber, so.SODate, so.CustomerID, so.BuyerID, so.PONumber, so.PODate,jo.DocumentNo,
// 					sod.ID, sod.ProductID, sod.Quantity, sod.UnitID, sod.Weight, sod.WeightUnitID,
// 					soda.RefNo,pcb.DocumentNo,soda.HangerNo,
// 					pcb.ID, pcb.DocumentNo, pcb.Gross,soda.PONumber,
// 					pcb.Quantity, pcb.UnitID, pcb.ScheduledDate, pcb.ProductionScheduledDate,
// 					pcblp.DepartmentID,pcb.LotNo,pcb.PCID,pcb.ChildLevel,pcb.RootID,sod.RequiredDate
// 				) x inner join
// 				ProductMaster pm on x.ProductID = pm.ID left join
// 				Departments dep on x.DepartmentID  = dep.ID left join
// 				Departments pdep on dep.RootID = pdep.ID left join				
// 				Partners cust on x.CustomerID = cust.ID left join
// 				Partners buy on x.BuyerID = buy.ID left join
// 				UnitDescription udq on x.UnitID = udq.ID left join
// 				UnitDescription udw on x.WeightUnitID = udw.ID left join
// 				UnitDescription udb on x.BatchUnitID = udb.ID
// 			order by
// 				x.SODID, x.PCBID");
// 		  $r=sqlsrv_fetch_array($sql);
// $sql1=sqlsrv_query($conn,"select partnername from partners where id='$r[CustomerID]'");	
// $r1=sqlsrv_fetch_array($sql1);
// $sql2=sqlsrv_query($conn,"select partnername from partners where id='$r[BuyerID]'");	
// $r2=sqlsrv_fetch_array($sql2);
// $pelanggan=$r1['partnername'];
// $buyer=$r2['partnername'];
// $ko=sqlsrv_query($conn,"select  ko.KONo from
// 		ProcessControlJO pcjo inner join
// 		ProcessControl pc on pcjo.PCID = pc.ID left join
// 		KnittingOrders ko on pc.CID = ko.CID and pcjo.KONo = ko.KONo 
// 	where
// 		pcjo.PCID = '$r[PCID]'
// group by ko.KONo");
// 					$rKO=sqlsrv_fetch_array($ko);
					
// $child=$r['ChildLevel'];
// 	if($nokk!=""){	
// 		if($child > 0){
// 			$sqlgetparent=sqlsrv_query($conn,"select ID,LotNo from ProcessControlBatches where ID='$r[RootID]' and ChildLevel='0'");
// 			$rowgp=sqlsrv_fetch_assoc($sqlgetparent);
			
// 			//$nomLot=substr("$row2[LotNo]",0,1);
// 			$nomLot=$rowgp['LotNo'];
// 			$nomorLot="$nomLot/K$r[ChildLevel]&nbsp;";				
								
// 		}else{
// 			$nomorLot=$r['LotNo'];
				
// 		}

// 		$sqlLot1="Select count(*) as TotalLot From ProcessControlBatches where PCID='$r[PCID]' and RootID='0' and LotNo < '1000'";
// 		$qryLot1 = sqlsrv_query($conn,$sqlLot1) or die('A error occured : ');							
// 		$rowLot=sqlsrv_fetch_assoc($qryLot1);
// 		$lotno=$rowLot['TotalLot']."-".$nomorLot;
		

}
$sqlCek=mysqli_query($con,"SELECT a.*,c.k_resep,c.acc_keluar,c.operator_keluar,c.shift as shift_keluar,c.g_shift as g_shift_keluar,c.id as idcelup from tbl_schedule a
INNER JOIN tbl_montemp b ON a.id=b.id_schedule
INNER JOIN tbl_hasilcelup c ON b.id=c.id_montemp 
WHERE a.nokk='$nokk' ORDER BY c.id DESC LIMIT 1");
$cek=mysqli_num_rows($sqlCek);
$rcek=mysqli_fetch_array($sqlCek);

$qcek1=mysqli_query($con,"SELECT * FROM tbl_potongcelup WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
$cek1=mysqli_num_rows($qcek1);
$rcek1=mysqli_fetch_array($qcek1);
$qcek2=mysqli_query($con,"SELECT * FROM tbl_montemp WHERE nokk='$nokk' and status='selesai' ORDER BY id DESC LIMIT 1");
$cek2=mysqli_num_rows($qcek2);
$rcek2=mysqli_fetch_array($qcek2);

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
                     onchange="window.location='?p=Form-Potong&nokk='+this.value" value="<?php echo $_GET['nokk'];?>" placeholder="No KK" required >
				<input name="id" type="hidden" value="<?php echo $rcek['idcelup']; ?>">  	  
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
                    <input name="no_order" type="text" class="form-control" id="no_order" placeholder="No Order" 
                    value="<?php if($cek>0){echo $rcek['no_order'];}else{if($r['NoOrder']!=""){echo $r['NoOrder'];}else if($nokk!=""){echo $cekM['no_order'];}} ?>" readonly="readonly">
                  </div>				   
                </div>
	    <div class="form-group">
                  <label for="no_po" class="col-sm-3 control-label">PO</label>
                  <div class="col-sm-5">
                    <input name="no_po" type="text" class="form-control" id="no_po" placeholder="PO" 
                    value="<?php if($cek>0){echo $rcek['po'];}else{if($r['PONumber']!=""){echo $r['PONumber'];}else if($nokk!=""){echo $cekM['po'];}} ?>" readonly="readonly" >
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
            <input name="tgl_delivery" type="text" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php if($cek>0){echo $rcek['tgl_delivery'];}else{if($r['RequiredDate']!=""){echo date('Y-m-d', strtotime($r['RequiredDate']));}}?>" readonly="readonly"/>
          </div>
        </div>
	  </div>
		<div class="form-group">
			  <label for="l_g" class="col-sm-3 control-label">Lebar X Gramasi</label>
			  <div class="col-sm-2">
				<input name="lebar" type="text" class="form-control" id="lebar" placeholder="0" 
				value="<?php if($cek>0){echo $rcek['lebar'];}else{echo round($r['Lebar']);} ?>" readonly="readonly">
			  </div>
			  <div class="col-sm-2">
				<input name="grms" type="text" class="form-control" id="grms" placeholder="0" 
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
	  </div>
	  		<!-- col --> 
	  <div class="col-md-6">
		<div class="form-group">
                  <label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="qty1" type="text" class="form-control" id="qty1" placeholder="0.00" 
                    value="<?php if($cek>0){echo $rcek['qty_order'];}else{echo round($r['BatchQuantity'],2);} ?>" readonly="readonly">
					  <span class="input-group-addon">KGs</span></div>  
                  </div>
				  <div class="col-sm-4">
					<div class="input-group">  
                    <input name="qty2" type="text" class="form-control" id="qty2" placeholder="0.00" style="text-align: right;" 
                    value="<?php if($cek>0){echo $rcek['pjng_order'];}else{echo round($r['Quantity'],2);} ?>" readonly="readonly">
                    <span class="input-group-addon">
							  <select name="satuan1" disabled="disabled" style="font-size: 12px;">
								  <option value="Yard" <?php if($r['UnitID']=="21"){ echo "SELECTED"; }?>>Yard</option>
								  <option value="Meter" <?php if($r['UnitID']=="10"){ echo "SELECTED"; }?>>Meter</option>
								  <option value="PCS" <?php if($r['UnitID']=="1"){ echo "SELECTED"; }?>>PCS</option>
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
				<input name="qty3" type="text" class="form-control" id="qty3" placeholder="0.00" 
				value="<?php if($cek2>0){echo $rcek2['rol'];}else{if($r['RollCount']!=""){echo round($r['RollCount']);}else if($nokk!=""){echo $cekM['jml_roll'];}} ?>" readonly="readonly">
			  </div>
			  <div class="col-sm-3">
				<div class="input-group">  
				<input name="qty4" type="text" class="form-control" id="qty4" placeholder="0.00" style="text-align: right;" 
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
							  <?php 
							  $sqlKap=mysqli_query($con,"SELECT kapasitas FROM tbl_mesin GROUP BY kapasitas ORDER BY kapasitas DESC");
							  while($rK=mysqli_fetch_array($sqlKap)){
							  ?>
								  <option value="<?php echo $rK['kapasitas']; ?>" <?php if($rcek['kapasitas']==$rK['kapasitas']){ echo "SELECTED"; }?>><?php echo $rK['kapasitas']; ?> KGs</option>
							 <?php } ?>	  
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
								  <option value="<?php echo $rK['no_mesin']; ?>" <?php if($rcek['no_mesin']==$rK['no_mesin']){ echo "SELECTED"; }?>><?php echo $rK['no_mesin']; ?></option>
							 <?php } ?>	  
					  </select>
				  </div>
					  
		</div>
		<div class="form-group">
                  <label for="no_rajut" class="col-sm-3 control-label">No Mesin Rajut</label>
                  <div class="col-sm-3">
                    <input name="no_rajut" type="text" class="form-control" id="no_rajut" placeholder="No Mesin Rajut" 
                    value="<?php echo $rcek['no_rajut'];?>" readonly="readonly">
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
                  <label for="operator" class="col-sm-3 control-label">Nama Operator </label>
                  <div class="col-sm-5">					  
						  <select name="operator" class="form-control" required>
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
                  <label for="k_resep" class="col-sm-3 control-label">Kestabilan Resep</label>
                  <div class="col-sm-2">					  
						  <select name="k_resep" class="form-control" disabled>
							  	<option value="0x" <?php if($rcek['k_resep']=="0x"){echo "SELECTED";} ?>>0x</option>			
							  	<option value="1x" <?php if($rcek['k_resep']=="1x"){echo "SELECTED";} ?>>1x</option>
							    <option value="2x" <?php if($rcek['k_resep']=="2x"){echo "SELECTED";} ?>>2x</option>
							  	<option value="3x" <?php if($rcek['k_resep']=="3x"){echo "SELECTED";} ?>>3x</option>
							    <option value="4x" <?php if($rcek['k_resep']=="4x"){echo "SELECTED";} ?>>4x</option>
							  	<option value="5x" <?php if($rcek['k_resep']=="5x"){echo "SELECTED";} ?>>5x</option>
					  </select>
				  </div>
					  
		</div>  
		<div class="form-group">
                  <label for="acc_kain" class="col-sm-3 control-label">Acc Kain Keluar </label>
                  <div class="col-sm-5">					  
						  <select name="acc_kain" class="form-control" disabled>
							  	<option value="">Pilih</option>
							  <?php 
							  $sqlKap=mysqli_query($con,"SELECT nama FROM tbl_staff WHERE jabatan='Colorist' or jabatan='SPV' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' ORDER BY nama ASC");
							  while($rK=mysqli_fetch_array($sqlKap)){
							  ?>
								  <option value="<?php echo $rK['nama']; ?>" <?php if($rcek['acc_keluar']==$rK['nama']){echo "SELECTED";} ?>><?php echo $rK['nama']; ?></option>
							 <?php } ?>	  
					  </select>
				  </div>
					  
		    </div>
		  <!--
		<div class="form-group">
                  <label for="comment_warna" class="col-sm-3 control-label">Comment Warna</label>
                  <div class="col-sm-6">
                    <input name="comment_warna" type="text" class="form-control" id="comment_warna" 
                    value="" placeholder="Comment Warna" >
                  </div>				   
        </div> 
          -->
      </div>
	  		
	 
		  <input type="hidden" value="<?php if($cek>0){echo $rcek['no_ko'];}else{echo $rKO['KONo'];}?>" name="no_ko">
		  
 	</div>
   	<div class="box-footer">      
   <button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button> 
   
   </div>
    <!-- /.box-footer -->
 </div>
</form>
    
						
                    

<?php 
	if($_POST['save']=="save"){
	  $cowarna=str_replace("'","''",$_POST['comment_warna']);	
  	  $sqlData=mysqli_query($con,"INSERT INTO tbl_potongcelup SET
		  id_hasilcelup='$_POST[id]',
		  nokk='$_POST[nokk]',
		  shift='$_POST[shift]',
		  g_shift='$_POST[g_shift]',
		  operator='$_POST[operator]',
		  comment_warna='$cowarna',
		  tgl_buat=now(),
		  tgl_update=now()");	 	  
	  
		if($sqlData){
			// echo "<script>alert('Data Tersimpan');</script>";
			// echo "<script>window.location.href='?p=Input-Data-KJ;</script>";
			echo "<script>swal({
  title: 'Data Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    
	 window.location.href='?p=Potong-Celup'; 
  }
});</script>";
		}
		
			
	}
    if($_POST['update']=="update"){
	  $cowarna=str_replace("'","''",$_POST['comment_warna']);
	  		
  	  $sqlData=mysqli_query($con,"UPDATE tbl_potongcelup SET 
		  comment_warna='$cowarna',
		  shift='$_POST[shift]',
		  g_shift='$_POST[g_shift]',
		  operator='$_POST[nokk]',
		  tgl_update=now()
		  WHERE nokk='$_POST[nokk]'");	 	  
	  
		if($sqlData){
			// echo "<script>alert('Data Telah Diubah');</script>";
			// echo "<script>window.location.href='?p=Input-Data-KJ;</script>";
			echo "<script>swal({
  title: 'Data Telah DiUbah',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    
	 window.location.href='?p=Potong-Celup'; 
  }
});</script>";
		}
		
			
	}
?>
