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
// 				pcb.ID as PCBID, pcb.Gross as Bruto,soda.HangerNo,pp.ProductCode,
// 				pcb.Quantity as BatchQuantity, pcb.UnitID as BatchUnitID, pcb.ScheduledDate, pcb.ProductionScheduledDate,
// 				pcblp.DepartmentID,pcb.LotNo,pcb.PCID,pcb.ChildLevel,pcb.RootID,sod.RequiredDate
				
// 			from
// 				SalesOrders so inner join
// 				JobOrders jo on jo.SOID=so.ID inner join
// 				SODetails sod on so.ID = sod.SOID inner join
// 				SODetailsAdditional soda on sod.ID = soda.SODID left join
// 				ProductPartner pp on pp.productid= sod.productid left join
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
// 					pcb.ID, pcb.DocumentNo, pcb.Gross,soda.PONumber,pp.ProductCode,
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
					
$child=$r['ChildLevel'];
	if($nokk!=""){	
		// if($child > 0){
		// 	$sqlgetparent=sqlsrv_query($conn,"select ID,LotNo from ProcessControlBatches where ID='$r[RootID]' and ChildLevel='0'");
		// 	$rowgp=sqlsrv_fetch_array($sqlgetparent);
			
		// 	//$nomLot=substr("$row2[LotNo]",0,1);
		// 	$nomLot=$rowgp['LotNo'];
		// 	$nomorLot="$nomLot/K$r[ChildLevel]";				
								
		// }else{
		// 	$nomorLot=$r['LotNo'];
				
		// }

		// $sqlLot1="Select count(*) as TotalLot From ProcessControlBatches where PCID='$r[PCID]' and RootID='0' and LotNo < '1000'";
		// $qryLot1 = sqlsrv_query($conn,$sqlLot1) or die('A error occured : ');							
		// $rowLot=sqlsrv_fetch_array($qryLot1);
		// $lotno=$rowLot['TotalLot']."-".$nomorLot;
		

}

$sqlCek1=mysqli_query($con,"SELECT * FROM tbl_datatest WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
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
                     	onchange="window.location='?p=Input-DataTest-Proses&nokk='+this.value" value="<?php echo $_GET['nokk'];?>" placeholder="No KK" required >
		  			</div>
			      	<!--<div class="col-sm-4">
				  		<input name="id" type="hidden" class="form-control" id="id" value="<?php echo $rcek['idc'];?>" placeholder="ID">
		          	</div>-->
        		</div>		  
				<div class="form-group">
                    <label for="langganan" class="col-sm-3 control-label">Langganan</label>
                    <div class="col-sm-8">
                        <input name="langganan" type="text" class="form-control" id="langganan" 
                        value="<?php if($cek1>0){echo $rcek1['langganan'];}else{echo $pelanggan;}?>" placeholder="Langganan">
                    </div>				   
                </div>
		        <div class="form-group">
                    <label for="buyer" class="col-sm-3 control-label">Buyer</label>
                    <div class="col-sm-8">
                        <input name="buyer" type="text" class="form-control" id="buyer" 
                        value="<?php if($cek1>0){echo $rcek1['buyer'];}else{echo $buyer;}?>" placeholder="Buyer">
                    </div>				   
                </div>
	            <div class="form-group">
                    <label for="no_order" class="col-sm-3 control-label">No Order</label>
                    <div class="col-sm-4">
                        <input name="no_order" type="text" class="form-control" id="no_order" 
                        value="<?php if($cek1>0){echo $rcek1['no_order'];}else{if($r['NoOrder']!=""){echo $r['NoOrder'];}else if($nokk!=""){echo $cekM['no_order'];}} ?>" placeholder="No Order">
                    </div>				   
                </div>
	            <div class="form-group">
                    <label for="no_po" class="col-sm-3 control-label">PO</label>
                    <div class="col-sm-5">
                        <input name="no_po" type="text" class="form-control" id="no_po" 
                        value="<?php if($cek1>0){echo $rcek1['po'];}else{if($r['PONumber']!=""){echo $r['PONumber'];}else if($nokk!=""){echo $cekM['no_po'];}} ?>" placeholder="PO" >
                    </div>				   
                </div>
		        <div class="form-group">
                    <label for="no_hanger" class="col-sm-3 control-label">No Hanger / No Item</label>
                    <div class="col-sm-3">
                        <input name="no_hanger" type="text" class="form-control" id="no_hanger" 
                        value="<?php if($cek1>0){echo $rcek1['no_hanger'];}else{if($r['HangerNo']){echo $r['HangerNo'];}else if($nokk!=""){echo $cekM['no_item'];}}?>" placeholder="No Hanger">  
                    </div>
                    <div class="col-sm-3">
                        <input name="no_item" type="text" class="form-control" id="no_item" 
                        value="<?php if($rcek1['no_item']!=""){echo $rcek1['no_item'];}else if($r['ProductCode']!=""){echo $r['ProductCode'];}else{if($r['HangerNo']){echo $r['HangerNo'];}else if($nokk!=""){echo $cekM['no_item'];}}?>" placeholder="No Item">
                    </div>	
                </div>
	            <div class="form-group">
                    <label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
                    <div class="col-sm-8">
					    <textarea name="jns_kain" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?php if($cek1>0){echo $rcek1['jenis_kain'];}else{if($r['ProductDesc']!=""){echo $r['ProductDesc'];}else if($nokk!=""){ echo $cekM['jenis_kain']; } }?></textarea>
					</div>
                </div>
		        <div class="form-group">
                    <label for="l_g" class="col-sm-3 control-label">Lebar X Gramasi</label>
                    <div class="col-sm-2">
                        <input name="lebar" type="text" class="form-control" id="lebar" 
                        value="<?php if($cek1>0){echo $rcek1['lebar'];}else{echo round($r['Lebar']);} ?>" placeholder="0" required>
                    </div>
                    <div class="col-sm-2">
                        <input name="grms" type="text" class="form-control" id="grms" 
                        value="<?php if($rcek1['gramasi']!=0){echo $rcek1['gramasi'];}else{echo round($r['Gramasi']);} ?>" placeholder="0" required>
                    </div>		
			    </div>
                <div class="form-group">
                    <label for="warna" class="col-sm-3 control-label">Warna</label>
                    <div class="col-sm-8">
                        <input name="warna" type="text" class="form-control" id="warna" 
                        value="<?php if($cek1>0){echo $rcek1['warna'];}else{if($r['Color']!=""){echo $r['Color'];}else if($nokk!=""){ echo $cekM['warna'];} }?>" placeholder="Warna">  
                    </div>				   
                </div>
                <div class="form-group">
                    <label for="no_warna" class="col-sm-3 control-label">No Warna</label>
                    <div class="col-sm-8">
                        <input name="no_warna" type="text" class="form-control" id="no_warna" 
                        value="<?php if($cek1>0){echo $rcek1['no_warna'];}else{if($r['ColorNo']!=""){echo $r['ColorNo'];}else if($nokk!=""){echo $cekM['no_warna'];}}?>" placeholder="No Warna">  
                    </div>				   
                </div>  
				<div class="form-group">
					<label for="jml_bruto" class="col-sm-3 control-label">Rol &amp; Qty</label>
					<div class="col-sm-2">
						<input name="roll" type="text" required class="form-control" id="roll" placeholder="0.00" 
						value="<?php if($cek1>0){echo $rcek1['roll'];}else{if($r['RollCount']!=""){echo round($r['RollCount']);}else if($nokk!=""){echo $cekM['jml_roll'];}} ?>">
					</div>
					<div class="col-sm-3">
						<div class="input-group">  
							<input name="bruto" type="text" required class="form-control" id="bruto" placeholder="0.00" style="text-align: right;" 
							value="<?php if($cek1>0){echo $rcek1['bruto'];}else{if($r['Weight']!=""){echo round($r['Weight'],2);}else if($nokk!=""){echo $cekM['bruto'];}} ?>">
							<span class="input-group-addon">KGs</span>
						</div>	
					</div>		
				</div>
		        <div class="form-group">
                    <label for="lot" class="col-sm-3 control-label">Lot</label>
                    <div class="col-sm-2">
                        <input name="lot" type="text" class="form-control" id="lot" 
                        value="<?php if($cek1>0){echo $rcek1['lot'];}else{if($nomorLot!=""){echo $lotno;}else if($nokk!=""){echo $cekM['lot'];} } ?>" placeholder="Lot" >
                    </div>				   
                </div>
				<div class="form-group">
                    <label for="demand_erp" class="col-sm-3 control-label">Demand ERP</label>
                    <div class="col-sm-2">
                        <input name="demand_erp" type="text" class="form-control" id="demand_erp" 
                        value="<?php if($cek1>0){echo $rcek1['demand_erp'];} ?>" placeholder="Demand ERP" required>
                    </div>	
					<label for="prodorder_erp" class="col-sm-3 control-label">Production Order ERP</label>
                    <div class="col-sm-2">
                        <input name="prodorder_erp" type="text" class="form-control" id="prodorder_erp" 
                        value="<?php if($cek1>0){echo $rcek1['prodorder_erp'];} ?>" placeholder="Prod. Order ERP" required>
                    </div>			   
                </div>
				<div class="form-group">
                    <label for="masalah" class="col-sm-3 control-label">Masalah</label>
                    <div class="col-sm-8">
                        <input name="masalah" type="text" class="form-control" id="masalah" 
                        value="<?php if($cek1>0){echo $rcek1['masalah'];} ?>" placeholder="Masalah">
                    </div>				   
                </div>
				<div class="form-group">
                    <label for="improve" class="col-sm-3 control-label">Improve</label>
                    <div class="col-sm-8">
                        <input name="improve" type="text" class="form-control" id="improve" 
                        value="<?php if($cek1>0){echo $rcek1['improve'];} ?>" placeholder="Improve">
                    </div>				   
                </div>  
			</div>
	  		<!-- col --> 
	  		<div class="col-md-6">
				<div class="form-group">
					<label for="no_mesin" class="col-sm-3 control-label">No MC</label>
                  <div class="col-sm-2">					  
						  <select name="no_mesin" class="form-control" id="no_mesin" required>
							  	<option value="">Pilih</option>
							  <?php 
							  $sqlKap=mysqli_query($con,"SELECT no_mesin FROM tbl_mesin ORDER BY no_mesin ASC");
							  while($rK=mysqli_fetch_array($sqlKap)){
							  ?>
								  <option value="<?php echo $rK['no_mesin']; ?>" <?php if($rcek1['no_mesin']==$rK['no_mesin']){echo "SELECTED";}?>><?php echo $rK['no_mesin']; ?></option>
							 <?php } ?>	 
					  </select>
				  </div>
				</div>
				<div class="form-group">
                  <label for="loading" class="col-sm-3 control-label">Loading</label>
                  	<div class="col-sm-3">
						<div class="input-group">  
                    		<input name="loading" type="text" style="text-align: right;" class="form-control" id="loading" 
                    		value="" placeholder="0.00" >
							<span class="input-group-addon">%</span>
						</div>	
                  	</div>				   
        		</div>
				<div class="form-group">
					<label for="l_r" class="col-sm-3 control-label">L:R</label>
						<div class="col-sm-2">
							<input name="l_r" type="text" class="form-control" id="l_r" 
							value="" placeholder="L:R" >
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
					<label for="rpm" class="col-sm-3 control-label">RPM</label>
					<div class="col-sm-2">
						<input name="rpm" type="text" class="form-control" id="rpm" 
							value="" placeholder="0" style="text-align: right;">
					</div>
					<label for="tekanan" class="col-sm-3 control-label">Tekanan</label>
          			<div class="col-sm-2">
                    	<input name="tekanan" type="text" class="form-control" id="tekanan" 
                    	value="" placeholder="0" style="text-align: right;">
                  	</div>		
				</div>
				<div class="form-group">
          			<label for="cycle_time" class="col-sm-3 control-label">Cycle Time</label>
          			<div class="col-sm-3">
						<div class="input-group">  
							<input name="cycle_time" type="text" class="form-control" id="cycle_time" 
							value="" placeholder="0" style="text-align: right;">
							<span class="input-group-addon">dtk</span>
					  	</div>	
                  	</div>
        		</div>
				<div class="form-group">
					<label for="nozzle" class="col-sm-3 control-label">&empty; Nozzle</label>
						<div class="col-sm-3">
								<select name="nozzle" class="form-control" required>
											<option value="">Pilih</option>
										<?php 
										$sqlNoz=mysqli_query($con,"SELECT nilai,satuan FROM tbl_nozzle ORDER BY nilai ASC");
										while($rN=mysqli_fetch_array($sqlNoz)){
										?>
											<option value="<?php echo $rN['nilai']; ?>"><?php echo $rN['nilai']." ".$rN['satuan']; ?></option>
										<?php } ?>	  
								</select>	
							</div>
					</div>
					<div class="form-group">
						<label for="blower" class="col-sm-3 control-label">Blower</label>
							<div class="col-sm-3">
								<div class="input-group">  
								<input name="blower" type="text" class="form-control" id="blower" 
								value="" placeholder="0" style="text-align: right;" required>
								<span class="input-group-addon">%</span>
								</div>	
							</div>				   
					</div>
					<div class="form-group">
						<label for="plaiter" class="col-sm-3 control-label">Plaiter</label>
							<div class="col-sm-3">
								<select name="plaiter" class="form-control" required>
									<option value="">Pilih</option>
									<option value="-">-</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>	
							</div>
					</div>
					<div class="form-group">
						<label for="file_grafik" class="col-sm-3 control-label">Upload Grafik</label>
							<div class="col-sm-6">	  
								<input type="file" id="file_grafik" name="file_grafik"><span style="color:red;"><?php if($rcek1['file_grafik']!=""){echo $rcek1['file_grafik'];} ?></span>
								<span class="help-block with-errors"></span>
							</div>	  
					</div> 
					<div class="form-group">
							<label for="ket_proses" class="col-sm-3 control-label">Keterangan Proses</label>
							<div class="col-sm-8">					  
									<textarea name="ket_proses" class="form-control"></textarea>
							</div>
					</div> 
					<div class="form-group">
						<label for="file_inspek" class="col-sm-3 control-label">Upload Inspeksi</label>
							<div class="col-sm-6">	  
								<input type="file" id="file_inspek" name="file_inspek"><span style="color:red;"><?php if($rcek1['file_inspek']!=""){echo $rcek1['file_inspek'];} ?></span>
								<span class="help-block with-errors"></span>
							</div>	  
					</div>  
					<div class="form-group">
							<label for="update_status" class="col-sm-3 control-label">Update Status</label>
							<div class="col-sm-8">					  
									<textarea name="update_status" class="form-control"></textarea>
							</div>
					</div> 
			  	<!-- <div class="form-group">
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
          			<label for="t_jawab" class="col-sm-3 control-label">Penanggung Jawab</label>
                  	<div class="col-sm-5">
                        <div class="input-group">					  
				    	<select name="t_jawab" class="form-control select2" required>
							<option value="">Pilih</option>
							<?php 
							$sqlTj=mysqli_query($con,"SELECT nama FROM tbl_tjawabdttest ORDER BY nama ASC");
							while($rTj=mysqli_fetch_array($sqlTj)){
							?>
							<option value="<?php echo $rTj['nama']; ?>" <?php if($rcek1['t_jawab']==$rTj['nama']){echo "SELECTED";} ?>><?php echo $rTj['nama']; ?></option>
							<?php } ?>
					  	</select>
                        <span class="input-group-btn"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#DataTJawab"> ...</button></span>
						</div>
				  	</div>
	    		</div> -->
				<!-- <div class="form-group">
					<label for="ket" class="col-sm-3 control-label">Keterangan</label>
					<div class="col-sm-7">
						<div class="input-group">
						<select class="form-control select2" multiple="multiple" data-placeholder="Keterangan" name="ket[]" id="ket" required>
							<option value="">Pilih</option>
							<?php
							$dtArr=$rcek1['ket'];	
							$data = explode(",",$dtArr);
							$qCek1=mysqli_query($con,"SELECT ket FROM tbl_ketdttest ORDER BY ket ASC");
							$i=0;	
							while($dCek1=mysqli_fetch_array($qCek1)){ ?>
							<option value="<?php echo $dCek1['ket'];?>" <?php if($dCek1['ket']==$data[0] or $dCek1['ket']==$data[1] or $dCek1['ket']==$data[2] or $dCek1['ket']==$data[3] or $dCek1['ket']==$data[4] or $dCek1['ket']==$data[5]){echo "SELECTED";} ?>><?php echo $dCek1['ket'];?></option>
							<?php $i++;} ?> 
						</select>
						<span class="input-group-btn"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#DataKet"> ...</button></span>
						</div>
		 	 		</div>
				</div> -->
      		</div>  		
 		</div>
   		<div class="box-footer">
			<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Input-DataTest-Proses'">Batal <i class="fa fa-arrow-circle-o-left"></i></button>
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
date_default_timezone_set("Asia/Jakarta");
//$bln=array(1 => "1","2","3","4","5","6","7","8","9","10","11","12");
//$romawi= $bln[date('n')];
//Baca Tanggal Hari ini
$bln = date('n');
$thn = date('y');
$bulan = date("Y-m");
$nomor="/".$bln."/".$thn."/DYE";
//Cari nomor terakhir pada database
$sql = "SELECT max(no_test) as maxKode FROM tbl_datatest WHERE tgl_buat LIKE '$bulan%'";
$hasil = mysqli_query($con,$sql) or die (mysqli_error());
$data = mysqli_fetch_array($hasil);
$notest= $data['maxKode'];
$noUrut=$notest + 1;
$kode =  sprintf("%03s", $noUrut);
$nomorbaru = $kode.$nomor;

	if($_POST['simpan']=="simpan"){
	  $no_test=$nomorbaru;			
	  $ket=str_replace("'","''",$_POST['ket']);
	  $masalah=str_replace("'","''",$_POST['masalah']);
	  $improve=str_replace("'","''",$_POST['improve']);
	  $ket_proses=str_replace("'","''",$_POST['ket_proses']);
	  $update_status=str_replace("'","''",$_POST['update_status']);
	  $file_grafik = $_FILES['file_grafik']['name'];
	  $file_inspek = $_FILES['file_inspek']['name'];
	// ambil data file
	$namaFile_grafik = $_FILES['file_grafik']['name'];
	$namaSementara_grafik = $_FILES['file_grafik']['tmp_name'];
	// tentukan lokasi file akan dipindahkan
	$dirUpload = "dist/img-grafikdatatest/";
	// pindahkan file
	$terupload_grafik = move_uploaded_file($namaSementara_grafik, $dirUpload.$namaFile_grafik);
	// ambil data file
	$namaFile_inspek = $_FILES['file_inspek']['name'];
	$namaSementara_inspek = $_FILES['file_inspek']['tmp_name'];
	// tentukan lokasi file akan dipindahkan
	$dirUpload = "dist/pdf-inspekdatatest/";
	// pindahkan file
	$terupload_inspek = move_uploaded_file($namaSementara_inspek, $dirUpload.$namaFile_inspek);
	  if(isset($_POST["ket"]))  
        { 
            // Retrieving each selected option 
            foreach ($_POST['ket'] as $index => $subject1){
				   if($index>0){
					  $jk1=$jk1.",".$subject1; 
				   }else{
					   $jk1=$subject1;
				   }	
				    
			}
        } 
  	  $sqlData=mysqli_query($con,"INSERT INTO tbl_datatest SET
		nokk='$_POST[nokk]',
		no_test='$no_test',
        langganan='$_POST[langganan]',
        buyer='$_POST[buyer]',
        no_order='$_POST[no_order]',
        po='$_POST[no_po]',
        no_hanger='$_POST[no_hanger]',
        no_item='$_POST[no_item]',
        jenis_kain='$_POST[jns_kain]',
        warna='$_POST[warna]',
        no_warna='$_POST[no_warna]',
        roll='$_POST[roll]',
        bruto='$_POST[bruto]',
        lot='$_POST[lot]',
        lebar='$_POST[lebar]',
        gramasi='$_POST[gramasi]',
		no_mesin='$_POST[no_mesin]',
		masalah='$masalah',
		improve='$improve',
		loading='$_POST[loading]',
		l_r='$_POST[l_r]',
		no_program='$_POST[no_program]',
		demand_erp='$_POST[demand_erp]',
		prodorder_erp='$_POST[prodorder_erp]',
		rpm='$_POST[rpm]',
		cycle_time='$_POST[cycle_time]',
		tekanan	='$_POST[tekanan]',
		nozzle='$_POST[nozzle]',
		blower='$_POST[blower]',
		plaiter='$_POST[plaiter]',
		file_grafik='$file_grafik',
		ket_proses='$ket_proses',
		file_inspek='$file_inspek',
		update_status='$update_status',
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
    
	 window.location.href='?p=Input-DataTest-Proses'; 
  }
});</script>";
		}
			
	}
    if($_POST['update']=="update"){
	  $ket=str_replace("'","''",$_POST['ket']);	
	  if(isset($_POST["ket"]))  
        { 
            // Retrieving each selected option 
            foreach ($_POST['ket'] as $index => $subject1){
				   if($index>0){
					  $jk1=$jk1.",".$subject1; 
				   }else{
					   $jk1=$subject1;
				   }	
				    
			}
        }
  	  $sqlData=mysqli_query($con,"UPDATE tbl_datatest SET 
	        langganan='$_POST[langganan]',
            buyer='$_POST[buyer]',
            no_order='$_POST[no_order]',
            po='$_POST[no_po]',
            no_hanger='$_POST[no_hanger]',
            no_item='$_POST[no_item]',
            jenis_kain='$_POST[jns_kain]',
            warna='$_POST[warna]',
            no_warna='$_POST[no_warna]',
            roll='$_POST[roll]',
            bruto='$_POST[bruto]',
            lot='$_POST[lot]',
            lebar='$_POST[lebar]',
            gramasi='$_POST[gramasi]',
            shift='$_POST[shift]',
            g_shift='$_POST[g_shift]',
            ket='$jk1',
            t_jawab='$_POST[t_jawab]',
		    tgl_update=now()
		    WHERE nokk='$_POST[nokk]'");	 	  
	  
		if($sqlData){			
			echo "<script>swal({
  title: 'Data Telah DiUbah',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    
	 window.location.href='?p=Input-DataTest-Proses'; 
  }
});</script>";
		}
		
			
	}
?>
<div class="modal fade" id="DataTJawab">
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Penanggung Jawab</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="form-group">
                  <label for="t_jawab" class="col-md-3 control-label">Penanggung Jawab</label>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="t_jawab" name="t_jawab" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>		    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<input type="submit" value="Simpan" name="simpan_tjawab" id="simpan_tjawab" class="btn btn-primary pull-right" >  
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>
<?php 
if($_POST['simpan_tjawab']=="Simpan"){
	$tjawab=strtoupper($_POST['t_jawab']);
	$sqlData1=mysqli_query($con,"INSERT INTO tbl_tjawabdttest SET 
		  nama='$tjawab'");
	if($sqlData1){	
	echo "<script>swal({
  title: 'Data Telah Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
         window.location.href='?p=Input-DataTest-Proses';
	 
  }
});</script>";
		}
}
?>

<div class="modal fade" id="DataKet">
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Keterangan Data Test Proses</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="form-group">
                  <label for="ket" class="col-md-3 control-label">Keterangan</label>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="ket" name="ket" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>		    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<input type="submit" value="Simpan" name="simpan_ket" id="simpan_ket" class="btn btn-primary pull-right" >  
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>
<?php 
if($_POST['simpan_ket']=="Simpan"){
	$ket=strtoupper($_POST['ket']);
	$sqlData1=mysqli_query($con,"INSERT INTO tbl_ketdttest SET 
		  ket='$ket'");
	if($sqlData1){	
	echo "<script>swal({
  title: 'Data Telah Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
         window.location.href='?p=Input-DataTest-Proses';
	 
  }
});</script>";
		}
}
?>
