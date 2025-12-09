<?php
    ini_set("error_reporting", 1);
    include "../../koneksi.php";
?>
<html>

<head>
  <title>:: Cetak Reports Buka Resep</title>
  <link href="styles_cetak.css" rel="stylesheet" type="text/css">
  <style>
    input {
      text-align: center;
      border: hidden;
    }

    @media print {
      ::-webkit-input-placeholder {
        /* WebKit browsers */
        color: transparent;
      }

      :-moz-placeholder {
        /* Mozilla Firefox 4 to 18 */
        color: transparent;
      }

      ::-moz-placeholder {
        /* Mozilla Firefox 19+ */
        color: transparent;
      }

      :-ms-input-placeholder {
        /* Internet Explorer 10+ */
        color: transparent;
      }

      .pagebreak {
        page-break-before: always;
      }

      .header {
        display: block
      }

      table thead {
        display: table-header-group;
      }
    }
  </style>
</head>
<body>
    <table border="0" style="width:100%" class="table-list1">
        <thead>
            <tr valign="middle">
                <td width="6%" rowspan="3"><img src="Indo.jpg" alt="" width="60" height="60"></td>
                <td width="94%" rowspan="3">
                    <div align="center">
                        <h1>FORM MATCHING GAGAL PROSES</h1>
                        <p>FW - DYE - 14 - 27 / 00</p>
                    </div>
                </td>
            </tr>
        </thead>
    </table>
    <?php
        $id = $_GET['id'];
        $q_matching_dyeing  = mysqli_query($con, "SELECT * FROM tbl_matching_dyeing WHERE id = '$id'");
        $row_matching_dyeing = mysqli_fetch_assoc($q_matching_dyeing);
    ?>
    <table border="0" style="width:100%" class="table-list1">
        <thead>
            <tr>
                <td colspan="3" width="14%">No Prod Order</td>
                <td colspan="1" width="1%">:</td>
                <td colspan="12" width="30%"><?= $row_matching_dyeing['nokk']; ?></td>

                <td colspan="4" width="14%">Dari Mesin</td>
                <td colspan="1" width="1%">:</td>
                <td colspan="7" width="30%">......</td>
            </tr>
            <tr>
                <td colspan="3" width="14%">No Order</td>
                <td colspan="1" width="1%">:</td>
                <td colspan="12" width="30%"><?= $row_matching_dyeing['no_order']; ?></td>

                <td colspan="4" width="14%">Roll</td>
                <td colspan="1" width="1%">:</td>
                <td colspan="7" width="30%">......</td>
            </tr>
            <tr>
                <td colspan="3">Langganan</td>
                <td colspan="1">:</td>
                <td colspan="12"><?= $row_matching_dyeing['langganan']; ?></td>

                <td colspan="4">Quantity (Kg)</td>
                <td colspan="1">:</td>
                <td colspan="7">......</td>
            </tr>
            <tr>
                <td colspan="3">Jenis Kain</td>
                <td colspan="1">:</td>
                <td colspan="12"><?= $row_matching_dyeing['jenis_kain']; ?></td>

                <td colspan="4">Loading (%)</td>
                <td colspan="1">:</td>
                <td colspan="7">......</td>
            </tr>
            <tr>
                <td colspan="3">Warna</td>
                <td colspan="1">:</td>
                <td colspan="12"><?= $row_matching_dyeing['warna']; ?></td>

                <td colspan="4">Proses Matching</td>
                <td colspan="1">:</td>
                <td colspan="7">......</td>
            </tr>
            <tr>
                <td colspan="3">No Warna</td>
                <td colspan="1">:</td>
                <td colspan="12"><?= $row_matching_dyeing['no_warna']; ?></td>

                <td colspan="4">Suhu X Waktu (Poly)</td>
                <td colspan="1">:</td>
                <td colspan="3">......</td>
                <td colspan="1" align="center">X</td>
                <td colspan="3">......</td>
            </tr>
            <tr>
                <td colspan="3">No Bon Resep 1</td>
                <td colspan="1">:</td>
                <td colspan="12">....</td>

                <td colspan="4">L:R Poly</td>
                <td colspan="1">:</td>
                <td colspan="7">......</td>
            </tr>
            <tr>
                <td colspan="3">No Bon Resep 2</td>
                <td colspan="1">:</td>
                <td colspan="12">....</td>

                <td colspan="4">Suhu X Waktu (Cotton)</td>
                <td colspan="1">:</td>
                <td colspan="3">......</td>
                <td colspan="1" align="center">X</td>
                <td colspan="3">......</td>
            </tr>
            <tr>
                <td colspan="3">Std Cocok Warna</td>
                <td colspan="1">:</td>
                <td colspan="12">1.</td>

                <td colspan="4">L:R Cotton</td>
                <td colspan="1">:</td>
                <td colspan="7">......</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td colspan="1">:</td>
                <td colspan="12">2.</td>

                <td colspan="4">Berat Kain (gr)</td>
                <td colspan="1">:</td>
                <td colspan="7">......</td>
            </tr>
            <tr>
                <td colspan="3">Lampu</td>
                <td colspan="1">:</td>
                <td colspan="12">1.</td>

                <td colspan="4">Acc Matching</td>
                <td colspan="1">:</td>
                <td colspan="7">......</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td colspan="1">:</td>
                <td colspan="12">2.</td>

                <td colspan="4"></td>
                <td colspan="1"></td>
                <td colspan="7"></td>
            </tr>           
        </thead>
    </table>
    <table border="0" style="width:100%" class="table-list1">
        <thead>
            <tr>
                <td colspan="1" rowspan="2" width="1%">No</td>
                <td colspan="2" rowspan="2" width="4%" align="center">KODE DYESTUFF / AUXILIARIES</td>
                <td colspan="5" rowspan="2" width="20%" align="center">NAMA DYESTUFF / AUXILIARIES</td>
                <td colspan="20" rowspan="1" width="75%" align="center">NOMOR PERCOBAAN DAN KONSENTRASI RESEP</td>
            </tr>
            <tr align="center">
                <td colspan="2" rowspan="1">1</td>
                <td colspan="2" rowspan="1">2</td>
                <td colspan="2" rowspan="1">3</td>
                <td colspan="2" rowspan="1">4</td>
                <td colspan="2" rowspan="1">5</td>
                <td colspan="2" rowspan="1">6</td>
                <td colspan="2" rowspan="1">7</td>
                <td colspan="2" rowspan="1">8</td>
                <td colspan="2" rowspan="1">9</td>
                <td colspan="2" rowspan="1">10</td>
            </tr>
            <tr>
                <td colspan="1">1</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">2</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">3</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">4</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">5</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">6</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">7</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">8</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">9</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">10</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
        </thead>
    </table>
    <table border="0" style="width:100%" class="table-list1">
        <thead>
            <tr>
                <td colspan="1" rowspan="2" width="1%">No</td>
                <td colspan="2" rowspan="2" width="4%" align="center">KODE DYESTUFF / AUXILIARIES</td>
                <td colspan="5" rowspan="2" width="20%" align="center">NAMA DYESTUFF / AUXILIARIES</td>
                <td colspan="20" rowspan="1" width="75%" align="center">NOMOR PERCOBAAN DAN KONSENTRASI RESEP</td>
            </tr>
            <tr align="center">
                <td colspan="2" rowspan="1">1</td>
                <td colspan="2" rowspan="1">2</td>
                <td colspan="2" rowspan="1">3</td>
                <td colspan="2" rowspan="1">4</td>
                <td colspan="2" rowspan="1">5</td>
                <td colspan="2" rowspan="1">6</td>
                <td colspan="2" rowspan="1">7</td>
                <td colspan="2" rowspan="1">8</td>
                <td colspan="2" rowspan="1">9</td>
                <td colspan="2" rowspan="1">10</td>
            </tr>
            <tr>
                <td colspan="1">1</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">2</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">3</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">4</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">5</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">6</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">7</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">8</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">9</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="1">10</td>
                <td colspan="2"></td>
                <td colspan="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
        </thead>
    </table>
    STATUS : URGENT / MATCHING DALAM MC / KAIN BASAH / KK OVEN
    <table border="0" style="width:100%" class="table-list1">
        <thead>
            <tr>
                <td colspan="8" width="25%"></td>
                <td colspan="10" align="center">DBUAT OLEH :</td>
                <td colspan="10" align="center">DIPERIKSA OLEH :</td>
            </tr>
            <tr>
                <td colspan="8">NAMA</td>
                <td colspan="10" align="center"><input name=nama type=text placeholder="Ketik disini" size="33" maxlength="30"></td>
                <td colspan="10" align="center"><input name=nama type=text placeholder="Ketik disini" size="33" maxlength="30"></td>
            </tr>
            <tr>
                <td colspan="8">JABATAN</td>
                <td colspan="10" align="center"><input name=nama type=text placeholder="Ketik disini" size="33" maxlength="30"></td>
                <td colspan="10" align="center"><input name=nama type=text placeholder="Ketik disini" size="33" maxlength="30"></td>
            </tr>
            <tr>
                <td colspan="8">TANGGAL</td>
                <td colspan="10" align="center"><input name=nama type=text placeholder="dd-mm-yyyy" size="33" maxlength="30"></td>
                <td colspan="10" align="center"><input name=nama type=text placeholder="dd-mm-yyyy" size="33" maxlength="30"></td>
            </tr>
            <tr>
                <td colspan="8">TANDA TANGAN <br><br><br><br><br></td>
                <td colspan="10"></td>
                <td colspan="10"></td>
            </tr>
        </thead>
    </table>
</body>
</html>