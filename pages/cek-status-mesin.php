<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");

?>
<div class="modal-dialog modal-lg" style="width: 95%">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">No Mesin a :
        <?php echo $_GET['id']; ?>
      </h4>
    </div>
    <div class="modal-body table-responsive">
      <table id="tbl3" class="table table-bordered table-hover display" width="100%">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="5%">No KK</th>
            <th width="10%">No Urut</th>
            <th width="7%">Costumer</th>
            <th width="7%">Buyer</th>
            <th width="7%">Order</th>
            <th width="7%">Jenis Kain</th>
            <th width="7%">Hanger</th>
            <th width="7%">Warna</th>
            <th width="7%">Lot</th>
            <th width="7%">Roll</th>
            <th width="7%">Qty</th>
            <th width="7%">Proses</th>
            <th width="7%">Tgl Delivery</th>
            <th width="11%">Ket</th>
            <th width="10%">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php


          $qry = mysqli_query($con, "SELECT *,
                                          IF(DATEDIFF( now(), tgl_delivery ) > 0, 'Urgent',
                                          IF( DATEDIFF( now(), tgl_delivery ) > - 4, 'Potensi Delay', '' )) AS `sts`,
                                          CASE
                                            WHEN b.tgl_stop IS NOT NULL AND b.tgl_mulai IS NULL THEN 'stop mesin'
                                            ELSE a.status
                                          END AS status_aktual,
                                          b.ket_stopmesin
                                        FROM
                                          tbl_schedule a 
                                        LEFT JOIN tbl_montemp b ON b.id_schedule = a.id
                                        WHERE
                                          a.no_mesin = '$_GET[id]' 
                                          AND NOT a.`status` = 'selesai' 
                                        ORDER BY
                                          a.no_urut ASC ");
          $no = 1;

          $c = 0;
          while ($rowd = mysqli_fetch_array($qry)) {
            $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';

          ?>
            <tr>
              <td>
                <?php echo $no; ?>
              </td>
              <td>
                <?php echo $rowd['nokk']; ?>
              </td>
              <td><?php echo $rowd['no_urut']; ?></td>
              <td><?php echo $rowd['langganan']; ?></td>
              <td><?php echo $rowd['buyer']; ?></td>
              <td><?php echo $rowd['no_order']; ?></td>
              <td><?php echo $rowd['jenis_kain']; ?></td>
              <td><?php echo $rowd['no_hanger']; ?></td>
              <td><?php echo $rowd['warna']; ?></td>
              <td><?php echo $rowd['lot']; ?></td>
              <td><?php echo $rowd['rol']; ?></td>
              <td><?php echo $rowd['qty_order']; ?></td>
              <td><?php echo $rowd['proses']; ?></td>
              <td>
                <?php echo $rowd['tgl_delivery']; ?>
              </td>
              <td bgcolor="<?php echo $bg; ?>">
                <?php echo $rowd['ket_status']; ?>
                <br>
                <span class="label <?php if ($rowd['status_aktual'] == "sedang jalan") {
                                          echo "label-success";
                                        } elseif ($rowd['status_aktual'] == "antri mesin") {
                                          echo "label-primary";
                                        } else{
                                          echo "label-danger";
                                        }?>">
                  <?php echo $rowd['status_aktual']; ?>
                </span>
                <?php echo $rowd['ket_stopmesin']; ?>
              </td>
              <td bgcolor="<?php if ($rowd['sts'] == "Potensi Delay") {
                              echo " orange";
                            } else if ($rowd['sts'] == "Urgent") {
                              echo " red";
                            } ?>">
                <?php if ($rowd['sts'] != "") {
                  echo "<font color=white>$rowd[sts]</font>";
                } ?>
                <span class="label bg-abu"><?php echo $rowd['ket_kain']; ?></span>
              </td>
            </tr>
          <?php $no++;
          } ?>
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