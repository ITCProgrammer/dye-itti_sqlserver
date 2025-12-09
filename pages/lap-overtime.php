<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Over Time Mesin</title>
</head>

<body>
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Over Time Mesin</h3><br><br>
                                <!-- <div class="pull-right">
                                    <a href="pages/cetak/reports-buka-resep-print.php?&awal=<?= $Awal; ?>&akhir=<?= $Akhir; ?>&jam_awal=<?= $jamA; ?>&jam_akhir=<?= $jamAr; ?>&gshift=<?= $GShift; ?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-html="true" title="Form Laporan Harian Buka Bon Resep">
                                        <i class="fa fa-print"></i> print
                                    </a>
                                    <a href="pages/cetak/reports-buka-resep-excel.php?&awal=<?= $Awal; ?>&akhir=<?= $Akhir; ?>&jam_awal=<?= $jamA; ?>&jam_akhir=<?= $jamAr; ?>&gshift=<?= $GShift; ?>" class="btn btn-success" target="_blank" data-toggle="tooltip" data-html="true" title="Form Laporan Harian Buka Bon Resep">
                                        <i class="fa fa-file-excel-o"></i> Cetak
                                    </a>
                                </div> -->
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-hover table-striped" width="100%">
                                    <thead class="bg-blue">
                                        <tr>
                                            <th width="47"><div align="center">Waktu</div></th>
                                            <th width="47"><div align="center">Mesin</div></th>
                                            <th width="26"><div align="center">Prod. Order</div></th>
                                            <th width="26"><div align="center">Prod. Demand</div></th>
                                            <th width="165"><div align="center">Pelanggan</div></th>
                                            <th width="165"><div align="center">Buyer</div></th>
                                            <th width="121"><div align="center">No. Order</div></th>
                                            <th width="121"><div align="center">No. Item</div></th>
                                            <th width="125"><div align="center">Jenis Kain</div></th>
                                            <th width="88"><div align="center">Warna</div></th>
                                            <th width="85"><div align="center">No Warna</div></th>
                                            <th width="40"><div align="center">Lot</div></th>
                                            <th width="86"><div align="center">Delivery</div></th>
                                            <th width="48"><div align="center">Rol</div></th>
                                            <th width="50"><div align="center">Kg</div></th>
                                            <th width="71"><div align="center">Proses</div></th>
                                            <th width="90"><div align="center">Keterangan</div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $q_detailkk    = mysqli_query($con, "SELECT
                                                                                    a.no_mesin,
                                                                                    a.kapasitas,
                                                                                    a.nokk,
                                                                                    a.nodemand,
                                                                                    a.langganan,
                                                                                    a.buyer,
                                                                                    a.no_order,
                                                                                    a.no_hanger,
                                                                                    a.jenis_kain,
                                                                                    a.warna,
                                                                                    a.no_warna,
                                                                                    a.lot,
                                                                                    a.tgl_delivery,
                                                                                    a.rol,
                                                                                    a.bruto,
                                                                                    a.proses,
                                                                                    a.ket_status,
                                                                                    a.ket_kain,
                                                                                    TIME_FORMAT( timediff( b.tgl_target, now()), '%H:%i' ) AS lama 
                                                                                FROM
                                                                                    tbl_schedule a
                                                                                    LEFT JOIN tbl_montemp b ON a.id = b.id_schedule 
                                                                                WHERE
                                                                                -- 	a.no_mesin = '1413' 
                                                                                -- 	AND 
                                                                                    b.STATUS = 'sedang jalan' 
                                                                                    AND (
                                                                                        ISNULL( b.tgl_stop ) 
                                                                                    OR NOT ISNULL( b.tgl_mulai )) 
                                                                                    AND TIME_FORMAT( timediff( b.tgl_target, now()), '%H:%i' ) < 0
                                                                                ORDER BY
                                                                                    a.no_urut ASC ");
                                            $no = 1;
                                        ?>
                                        <?php while ($row_detailkk = mysqli_fetch_array($q_detailkk)) { ?>
                                            <tr bgcolor="antiquewhite">
                                            <td align="center"><?php echo $row_detailkk['lama']; ?></a></td>
                                            <td align="center"><?php echo $row_detailkk['no_mesin']; ?></a></td>
                                            <td align="center"><?php echo $row_detailkk['nokk']; ?></td>
                                            <td align="center"><?php echo $row_detailkk['nodemand']; ?></td>
                                            <td><?php echo $row_detailkk['langganan']; ?></td>
                                            <td><?php echo $row_detailkk['buyer']; ?></td>
                                            <td align="center"><?php echo $row_detailkk['no_order']; ?></td>
                                            <td align="center"><?php echo $row_detailkk['no_hanger']; ?></td>
                                            <td><?php echo $row_detailkk['jenis_kain']; ?></td>
                                            <td align="center"><?php echo $row_detailkk['warna']; ?></td>
                                            <td align="center"><?php echo $row_detailkk['no_warna']; ?></td>
                                            <td align="center"><a href="#"><?php echo $row_detailkk['lot']; ?></a></td>
                                            <td align="center"><?php echo $row_detailkk['tgl_delivery']; ?></td>
                                            <td align="center"><?php echo $row_detailkk['rol'] . $row_detailkk['kk']; ?></td>
                                            <td align="center"><?php echo $row_detailkk['bruto']; ?></td>
                                            <td align="center"><?php echo $row_detailkk['proses']; ?></td>
                                            <td align="center"><?php echo $row_detailkk['ket_status']; ?> <br><?php echo $row_detailkk['ket_kain']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot class="bg-red">
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</body>
</html>
