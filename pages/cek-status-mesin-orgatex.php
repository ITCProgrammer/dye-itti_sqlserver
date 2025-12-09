<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
include("./../koneksiORGATEX.php");

$sqlcek=mysqli_query($con,"SELECT no_mesin FROM tbl_mesin WHERE no_mesin_lama='" .$_GET['id']. "'");
$rcek  = mysqli_fetch_array($sqlcek);

?>
<div class="modal-dialog modal-lg" style="width: 95%">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">IP Address Orgatex:
        <?php echo $_GET['id']; ?><br><br>
		Machine NEW: <?php echo $rcek['no_mesin']; ?>  
      </h4>
    </div>
    <div class="modal-body table-responsive">
      <table id="tbl3" class="table table-bordered table-hover display" width="100%" style="font-size: 18px;">
        <thead>
          <?php 
			echo "<tr><th>Group No</th><th>Machine NEW</th><th>Machine</th><th>Nokk</th><th>DyelotRefNo</th><th>Batch Color</th><th>OnlineState</th><th>RunState</th><th>Alarm Name</th><th>Step No</th><th>Function Name</th><th>Time Opr Call</th><th>Temperature</th></tr>";
		  ?>	
        </thead>
        <tbody>
          <?php
			

        // Membuat query untuk mengambil data DyelotRefNo dari tabel MachineStatus
		$sql = "Select 
a.Dyelot as [Dyelot],		
m.MGroupNo as [Group No],
ms.Machine as [Machine], ms.DyelotRefNo as [Dyelot Ref Number], 
(Case When ms.DyelotRefNo collate Database_default is not null Then 
(Select bd.batch_text_01 where bd.batch_ref_no = ms.DyelotRefNo collate database_default)
Else 'No Batch Number'  End) as [Batch Number],
(Case When ms.OnlineState = 1 Then 'ON' When ms.OnlineState = 0 Then 'OFF' End) as [Online State], 
(Case When ms.RunState = 1 Then 'No Batch' When ms.RunState = 2 Then 'Batch Selected'
When ms.RunState = 3 Then 'Batch Running' When ms.RunState = 4 Then 'Controller Stopped' 
When ms.RunState = 5 Then 'Manual Operation' When ms.RunState = 6 Then 'Finished' End) as [Run State],
(Select Alarmlist.AlarmText from AlarmList where AlarmList.GroupNo = m.MGroupNo and AlarmList.AlarmNo = ms.Alarm) as [Alarm Name],
ms.Step as [Step No],
(Select FunctionList.FunctionText from FunctionList where FunctionList.GroupNo = m.MGroupNo and FunctionList.FunctionNo = ms.[Function]) as [Function Name],
ms.TimeToOpcall as [Time Opr Call], (ms.InfoWord1/66.6) as [Temperature],
FLOOR(ms.TimeToOpcall / 60) AS Hours,
ms.TimeToOpcall % 60 AS Minutes
from MachineStatus ms 
left join Dyelots a on ms.DyelotRefNo = a.DyelotRefNo
left join [ORGATEX].[DBO].[BatchDetail] bd on ms.DyelotRefNo = bd.batch_ref_no COLLATE DATABASE_DEFAULT
left join machines m on ms.Machine = m.MachineNo COLLATE DATABASE_DEFAULT
WHERE ms.RunState > 1 AND ms.Machine = ? ";

		// Menyiapkan statement dengan parameter
		$mc = $_GET['id'];	
		$params = array($mc); // Menyimpan parameter MachineCode
		$stmt = sqlsrv_query($connORG, $sql, $params);

		// Cek apakah query berhasil
		if ($stmt === false) {
			die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
		}
			
		  $no = 1;

          $c = 0;         

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {	
	$wkt=$row['Hours']." Hours ".$row['Minutes']." Minutes";
	$sql=mysqli_query($con,"SELECT no_mesin FROM tbl_mesin WHERE no_mesin_lama='" .$row['Machine']. "'");
	$r  = mysqli_fetch_array($sql);
    echo "<tr>";
    echo "<td>" .$row['Group No']. "</td>"; //Name here should be same as the SQL Statement as [Name]
    echo "<td>" .$r['no_mesin']. "</td>";
	echo "<td>" .$row['Machine']. "</td>";
	echo "<td>" .$row['Dyelot']. "</td>";
    echo "<td>" .$row['Dyelot Ref Number']. "</td>";
    echo "<td>" .$row['Batch Number']. "</td>";
    echo "<td>" .$row['Online State']. "</td>";
    echo "<td>" .$row['Run State']. "</td>";
    echo "<td>" .$row['Alarm Name']. "</td>";
    echo "<td>" .$row['Step No']. "</td>";
    echo "<td>" .$row['Function Name']. "</td>";
	echo "<td>" .$wkt. "</td>";
	echo "<td>" .round($row['Temperature'],1). "</td>";
    echo "</tr>";
}
			  
          ?>
            
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(function() {
    $("#tbl3").dataTable();
  });
</script>