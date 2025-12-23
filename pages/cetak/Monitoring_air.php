<?php
    ini_set("error_reporting", 1);
    include "../../koneksi.php";
    include "../../koneksiLAB.php";
    include "../../helpers.php";
    //--
    $idkk  = $_REQUEST['idkk'];
    $act   = $_GET['g'];
function q(string $key, string $default = ''): string
{
    return trim($_REQUEST[$key] ?? $default);
}

$no_mesin = q('ids');
$no_demand = q('nodemand');
$no_prod = q('idkk');
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cetak Form Monitoring Air</title>
    <script>
    // set portrait orientation

    jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);

    // set top margins in millimeters
    jsPrintSetup.setOption('marginTop', 0);
    jsPrintSetup.setOption('marginBottom', 0);
    jsPrintSetup.setOption('marginLeft', 0);
    jsPrintSetup.setOption('marginRight', 0);

    // set page header
    jsPrintSetup.setOption('headerStrLeft', '');
    jsPrintSetup.setOption('headerStrCenter', '');
    jsPrintSetup.setOption('headerStrRight', '');

    // set empty page footer
    jsPrintSetup.setOption('footerStrLeft', '');
    jsPrintSetup.setOption('footerStrCenter', '');
    jsPrintSetup.setOption('footerStrRight', '');

    jsPrintSetup.clearSilentPrint();

    jsPrintSetup.setOption('printSilent', 1);

    jsPrintSetup.print();

    window.addEventListener('load', function() {
        var rotates = document.getElementsByClassName('rotate');
        for (var i = 0; i < rotates.length; i++) {
            rotates[i].style.height = rotates[i].offsetWidth + 'px';
        }
    });
    // next commands
    </script>
    <style>
    body,
    td,
    th {
        /*font-family: Courier New, Courier, monospace; */
        font-family: sans-serif, Roman, serif;
    }

    body {
        margin: 0px auto 0px;
        padding: 0.5px;
        font-size: 10px;
        color: #000;
        width: 95%;
        background-position: top;
        background-color: #fff;
    }

    .table-list {
        clear: both;
        text-align: left;
        border-collapse: collapse;
        margin: 0px 0px 7px 0px;
        background: #fff;
    }

    .table-list td {
        color: #333;
        font-size: 11px;
        border-color: #fff;
        border-collapse: collapse;
        vertical-align: center;
        padding: 0px 1px;
        border-bottom: 1px #000000 solid;
        border-left: 1px #000000 solid;
        border-right: 1px #000000 solid;


    }

    pre {
        font-family: sans-serif, Roman, serif;
        clear: both;
        margin: 0px auto 0px;
        padding: 0px;
        white-space: pre-wrap;
        /* Since CSS 2.1 */
        white-space: -moz-pre-wrap;
        /* Mozilla, since 1999 */
        white-space: -pre-wrap;
        /* Opera 4-6 */
        white-space: -o-pre-wrap;
        /* Opera 7 */
        word-wrap: break-word;
    }

    .table-list1 {
        clear: both;
        text-align: left;
        border-collapse: collapse;
        margin: 0px 0px 3px 0px;
        vertical-align: top;

    }

    .table-list1 td {
        color: #333;
        font-size: 12px;
        border-color: #fff;
        border-collapse: collapse;
        vertical-align: center;
        padding: 0px 1px;
        border-bottom: 1px #000000 solid;
        border-top: 1px #000000 solid;
        border-left: 1px #000000 solid;
        border-right: 1px #000000 solid;


    }

    body:before {       
        content: '';
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: -1;

        color: #d0d0d0;
        font-size: 1000px;
        font-weight: 500px;
        display: grid;
        justify-content: center;
        align-content: center;
        opacity: 0.3;
        transform: rotate(-45deg);
    }

    .table-list1 tr.rowline td{
    height: 8px;          /* atur angka dasar sesuai kebutuhan */
    padding-top: 4px;
    padding-bottom: 4px;
    vertical-align: middle;
    }
    </style>
</head>

<body>
    <?php
      date_default_timezone_set('Asia/Jakarta');
      $sqlsmp1     = sqlsrv_query($con, "SELECT
                                           *,
                                            b.buyer,
                                            b.no_order,
                                            b.warna,
                                            b.nokk,
                                            b.nodemand,
                                            a.tgl_update,
                                            a.id AS idm,
                                            b.id AS ids,
                                            c.id AS idstm,
                                            a.g_shift AS sft, 
                                            a.l_r ,
                                            a.l_r_2,
                                            b.rol,
                                            b.bruto,
                                            a.waktu_tunggu,
                                            a.tgl_buat, 
                                            b.loading,
                                            b.no_mesin,
                                            a.operator,
                                            b.no_hanger,
                                            c.no_item,
                                            b.jenis_kain,
                                            b.lot,
                                            b.kapasitas
                                        FROM
                                            db_dying.tbl_montemp a
                                            LEFT JOIN db_dying.tbl_schedule b ON a.id_schedule = b.id
                                            LEFT JOIN db_dying.tbl_setting_mesin c ON b.nokk = c.nokk
                                            LEFT JOIN db_dying.tbl_bakbul d ON c.nokk = d.no_kk
                                        WHERE
                                            ( a.status = 'antri mesin' OR a.status = 'sedang jalan' ) 
                                            AND ( b.status = 'antri mesin' OR b.status = 'sedang jalan' ) 
                                            and a.nokk = '$no_prod' and a.nodemand ='$no_demand' and b.id = '$no_mesin'
                                        ORDER BY
                                            a.id ASC ");
    //   $rowmt       = sqlsrv_fetch_array($sqlsmp1);
    // if (!$sqlsmp1) {
    //     die("Query error: " . sqlsrv_error($con));
    // }

    // if (sqlsrv_num_rows($sqlsmp1) == 0) {
    //     die("Data tidak ditemukan. Parameter: idkk=$no_prod, nodemand=$no_demand, idm=$no_mesin");
    // }

    $rowmt = sqlsrv_fetch_array($sqlsmp1,SQLSRV_FETCH_ASSOC );
  ?>
    <h2 align="center">FORM PENGISIAN AIR PROSES DYEING</h2>  
    <table width="100%" class="table-list1">
         <tr>           
            <td style=" border:none !important;" width="2%">
                <pre>No. Mesin / Kapasitas</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo $rowmt['no_mesin']; ?> / <?php echo $rowmt['kapasitas']; ?>
            </td>
            <td style="border:none !important;" width="2%" >
                <pre>Tanggal Proses</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo formatDateTime($rowmt['tgl_buat'],'Y-m-d H:i:s'); ?>
            </td>
        </tr>

        <tr>           
            <td style="border:none !important;" width="2%">
               <pre>No.Demand</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo $rowmt['nodemand']; ?>
            </td>
            <td style="border:none !important;" width="2%">
                <pre>Roll x QTY</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo $rowmt['rol']; ?> / <?php echo $rowmt['bruto']; ?>
            </td>
        </tr>
        <tr>           
            <td style="border:none !important;" width="2%">
               <pre>No. Production Order</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo $rowmt['nokk']; ?>
            </td>
            <td style="border:none !important;" width="2%">
                <pre>Loading</pre>
            </td>
            <td style="border:none !important;"width="10%">:
                <?php echo $rowmt['loading']; ?>
            </td>
        </tr>
        <tr>           
            <td style="border:none !important; vertical-align:top; white-space:nowrap;">
                Item / Jenis Kain
            </td>
            <td style="border:none !important; vertical-align:top; padding:0;">
                <div style="display:flex; gap:4px; align-items:flex-start;">
                    <span>:</span>
                    <span style="white-space:normal; word-break:break-word;">
                        <?= $rowmt['no_item']; ?> / <?= $rowmt['jenis_kain']; ?>
                    </span>
                </div>
            </td>
            <td style="border:none !important;" width="2%">
                <pre>LR Poly</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo $rowmt['l_r']; ?>
            </td>
        </tr>
        <tr>           
            <td style="border:none !important;" width="2%">
               <pre>Warna</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo $rowmt['warna']; ?>
            </td>
            <td style="border:none !important;" width="2%">
                <pre>LR Cotton</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo $rowmt['l_r_2']; ?>
            </td>
        </tr>
        <tr>           
            <td style="border:none !important;" width="2%">
               <pre>Lot</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo $rowmt['lot']; ?>
            </td>            
        </tr>
    </table>
    <table width="100%" border="1" class="table-list1">
        <tr>
        <th class="col-no" width="2%"  align="center">No.</th>
        <th class="col-proses" width="25%"  align="center">Proses</th>
        <th class="col-air" width="25%"  align="center">Pemakaian Air (liter)</th>
        <th class="col-no" width="2%"  align="center">No.</th>
        <th class="col-proses" width="25%"  align="center">Proses</th>
        <th class="col-air" width="25%"  align="center">Pemakaian Air (liter)</th>
      </tr>
      <?php
        for ($i = 1; $i <= 15; $i++) {
            $j = $i + 15;
            echo "<tr class='rowline'>";
            echo "<td class='col-no'>" . $i . "</td>";
            echo "<td class='col-proses'></td>";
            echo "<td class='col-air'></td>";
            echo "<td class='col-no'>" . $j . "</td>";
            echo "<td class='col-proses'></td>";
            echo "<td class='col-air'></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <table width="100%" class="table-list1">
         <tr>           
            <td style=" border:none !important;" width="2%">
                <pre>Flowmeter Awal</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                
            </td>
            <td style="border:none !important;" width="2%" >
                <pre>Flowmeter Akhir</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                 
            </td>
        </tr>
          <tr>           
            <td style=" border:none !important;" width="2%">
                <pre>Keterangan</pre>
            </td>
            <td style="border:none !important;" width="10%">:
            </td>
        </tr>
        <tr>           
            <td style=" border:none !important;" width="2%">
                <pre> </pre>
            </td>
            <td style="border:none !important;" width="10%">
            </td>
        </tr>
        <tr>           
            <td style=" border:none !important;" width="2%">
                <pre></pre>
            </td>
            <td style="border:none !important;" width="10%">
            </td>
        </tr>
        <tr>           
            <td style=" border:none !important;" width="2%">
                <pre></pre>
            </td>
            <td style="border:none !important;" width="10%">
            </td>
        </tr>
        <tr>           
            <td style=" border:none !important;" width="2%">
                <pre>Operator</pre>
            </td>
            <td style="border:none !important;" width="10%">:
                <?php echo $rowmt['operator']; ?>
            </td>    
        </tr>                
    </table>   

    <?php
      //}
  ?>
    <script>
    alert('cetak');
    window.print();
    </script>
</body>

</html>