<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan NCP</title>
</head>
<body>
<?php
$Awal	= isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir	= isset($_POST['akhir']) ? $_POST['akhir'] : '';
$GShift	= isset($_POST['gshift']) ? $_POST['gshift'] : '';	
$Dept	= isset($_POST['dept']) ? $_POST['dept'] : '';
$NCP	= isset($_POST['no_ncp']) ? $_POST['no_ncp'] : '';	
$IDNCP	= isset($_GET['id']) ? $_GET['id'] : '';
if($_POST['gshift']=="ALL"){$shft=" ";}else{$shft=" AND b.g_shift = '$GShift' ";}	
	
function posisi($nokk){
//$host="10.0.0.4";
//$host="DIT\MSSQLSERVER08";
//$username="sa";
//$password="ditbin";
//$db_name="TM";
set_time_limit(600);
//$conn=mssql_connect($host,$username,$password) or die ("Sorry our web is under maintenance. Please visit us later");
//mssql_select_db($db_name) or die ("Under maintenance");
$sql=" select d.DepartmentName from PCCardPosition p left join
Departments d on d.ID=p.DepartmentID
left join ProcessControlBatches a on p.PCBID=a.ID
where a.DocumentNo='$nokk' and (d.DepartmentName='KK Oke' or p.CounterDepartmentID='60') order by p.Dated ";
// $qry=sqlsrv_query($conn,$sql);
// $jmrow=sqlsrv_num_rows($qry);
	// return $jmrow;
	
}	
?>
	<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> Informasi</h4>
                Klik No. NCP Pada Tabel -> Kolom Order untuk input data Tindakan Penyelesaian.
              </div>	
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Status NCP&nbsp;<span class="pull-right-container">
              <small class="label pull-right bg-green blink_me">new</small>
            </span></h3>             
	  </div>
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped nowrap" id="example3" style="width:100%">
        <thead class="bg-purple">
          <tr>
            <th width="3%"><div align="center">No</div></th>
            <th width="4%"><div align="center">Tgl Buat</div></th>
            <th width="11%"><div align="center">Lama Proses</div></th>
            <th width="11%"><div align="center">Langganan</div></th>
			      <th width="6%"><div align="center">Buyer</div></th>  
            <th width="3%"><div align="center">PO</div></th>
            <th width="6%"><div align="center">Order</div></th>
            <th width="6%"><div align="center">Tgl Target</div></th>
            <th width="20%"><div align="center">Jenis_Kain</div></th>
            <th width="7%"><div align="center">Lebar &amp; Gramasi</div></th>
            <th width="4%"><div align="center">Lot</div></th>
            <th width="7%"><div align="center">Lot Salinan</div></th>
            <th width="7%"><div align="center">Warna</div></th>
            <th width="4%"><div align="center">Rol</div></th>
            <th width="6%"><div align="center">Berat</div></th>
            <th width="5%"><div align="center">Dept</div></th>
            <th width="9%"><div align="center">Masalah</div></th>
            <th width="5%"><div align="center">Tempat Kain</div></th>
            <th width="5%"><div align="center">Ket</div></th>
            </tr>
        </thead>
        <tbody>
          <?php
	$no=1;	
	$pos=0;		
	if($_SESSION['dept']!="QC"){$where=" AND dept='DYE' ";}else{ $where=" ";}
	if($Dept!=""){$where1=" AND dept='$Dept' ";}else{ $where1=" ";}
	if($NCP!=""){$where2=" AND no_ncp_gabungan='$NCP' ";}else{ $where2=" ";}
	if($IDNCP!=""){$where3=" AND id='$IDNCP' ";}else{ $where3=" ";}		
	$qry1=mysqli_query($cond,"SELECT *,DATEDIFF(tgl_rencana,DATE_FORMAT(now(),'%Y-%m-%d')) as lama, DATEDIFF(DATE_FORMAT(now(),'%Y-%m-%d'),tgl_rencana) as delay 
	FROM tbl_ncp_qcf_now WHERE (ISNULL(analisa_masalah) or analisa_masalah='') ".$where.$where1.$where2.$where3." ORDER BY id ASC");
			while($row1=mysqli_fetch_array($qry1)){
		//$pos=posisi($row1[nokk]);		
		//if($pos>0){}
		//else{		
		$sql=mysqli_query($cond,"SELECT COUNT(*) jml,tgl_terima,id FROM `tbl_qcf_ncp_tolak_new` WHERE id_qcf_ncp='$row1[id]' ORDER BY id DESC");
		$r1=mysqli_fetch_array($sql);
				if($row1['nokk_salinan']!=""){
					$nokk1=$row1['nokk_salinan'];
				}else{
					$nokk1=$row1['nokk'];
				}
									
		 ?>
          <tr bgcolor="<?php echo $bgcolor; ?>">
			<td align="center"><font size="-1"><?php echo $no; ?></font></td>
			<td align="center"><font size="-1"><?php echo $row1['tgl_buat'];?></font><br><div class="btn-group"><a href="#" class="btn btn-xs btn-primary analisa_masalah " id="<?php echo $row1['id'].".".$_POST['awal'].",".$_POST['akhir'];?>"><i class="fa fa-edit"></i></a><a href="pages/cetak/cetak_ncp_new.php?id=<?php echo $row1['id'];?>" class="btn btn-xs btn-danger disabled" target="_blank"><i class="fa fa-print"></i></a><a href="pages/cetak/cetak_ncp_new_pdf.php?id=<?php echo $row1['id'];?>" class="btn btn-xs btn-info disabled" target="_blank"><i class="fa fa-file-pdf-o"></i></a></div></td>
			<td align="center"><?php if($row1['delay']>0){echo "<span class='label label-danger'>Delay ".$row1['delay']." Hari</span>";}else if($row1['delay']<=0 and $row1['delay']!=""){echo "<span class='label label-success'>".$row1['lama']." Hari Lagi</span>";}else {echo "<span class='label bg-fuchsia'>NCP belum-diterima</span>";}?><br>
			<a href="#" class="posisi_kk" id="<?php echo $nokk1; ?>"><?php echo $nokk1; ?></a></td>
            <td><font size="-1"><?php echo $row1['langganan'];?></font><br><a href="StatusNCPNewUbah-<?php echo $row1['id']; ?>" class="btn <?php if($_SESSION['dept']!="QC"){ echo "disabled";}?>"><span class="label <?php if($row1['status']=="OK"){echo "label-success";}else{echo "label-warning";} ?> "><?php echo $row1['status'];?></span></a><?php if($row1['tgl_rencana']!="" and $row1['penyelesaian']==""){ echo"<span class='label label-primary'>Sudah diterima ".$row1['dept']."</span>";}else if($row1['tgl_rencana']!="" and $row1['penyelesaian']!=""){ echo"<span class='label label-danger'>Tunggu OK dari QCF</span>";}?></td>
			      <td><font size="-1"><?php echo $row1['buyer'];?></font></td>  
            <td align="center"><font size="-1"><?php echo $row1['po'];?></font></td>
			      <td align="center"><font size="-1"><?php echo $row1['no_order'];?></font><br><a href="?p=penyelesaian-new&id=<?php echo $row1['id']; ?>" class="btn"><span class="label label-danger"><?php echo $row1['no_ncp_gabungan'];?></span></a><br>
					  <?php echo $row1['nokk']; ?>
					  <?php if($r1['tgl_terima']=="" and $r1['jml']>0){ ?><a href="#" class="btn terima_ncp_lama" id="<?php echo $r1['id']; ?>"><span class="label label-success">NCP Lama</span></a>
					   <?php } ?></td>
            <td><font size="-1"><?php echo $row1['tgl_rencana'];?></font></td>
            <td><font size="-2"><?php echo $row1['jenis_kain'];?></font></td>
            <td align="center"><font size="-1"><?php echo $row1['lebar']."x".$row1['gramasi'];?></font></td>
            <td align="center"><font size="-1"><?php echo $row1['lot'];?></font></td>
            <td align="center"><font size="-1"><?php echo $row1['lot_salinan'];?></font></td>
            <td align="center"><font size="-2"><?php echo $row1['warna'];?></font></td>
            <td align="right"><font size="-1"><?php echo $row1['rol'];?></font></td>
            <td align="right"><font size="-1"><?php echo $row1['berat'];?></font></td>
            <td align="center"><font size="-1"><?php echo $row1['dept'];?></font></td>
            <td><font size="-1"><?php echo $row1['masalah'];?></font></td>
            <td><font size="-1"><?php echo $row1['tempat'];?></font></td>
            <td><font size="-1"><?php echo $row1['ket'];?></font></td>
            </tr>
          <?php	//} 
				$no++;  } ?>
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="StsNewEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="PosisiKK" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>		
<div id="SelesaiNewEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="NcpLamaNew" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="NcpLamaTerimaNEw" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="AnalisaMasalah" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>	
<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	</script>
</body>
</html>