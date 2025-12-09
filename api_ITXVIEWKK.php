<?php
    session_start();
    include_once "koneksi.php";
    $_noprod    = $_GET['noprod'];
    $_noprod_   = sprintf("%08d", $_noprod);
    $sql = "SELECT
                TRIM(PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
                LISTAGG(TRIM(DEAMAND), ', ') AS DEMAND,
                SUBSTRING(LISTAGG(ORIGDLVSALORDERLINEORDERLINE, ','), 1,3) AS ORDERLINE,
                TRIM(PROJECTCODE) AS PROJECTCODE,
                ORDPRNCUSTOMERSUPPLIERCODE,
                TRIM(SUBCODE01) AS SUBCODE01, 
                TRIM(SUBCODE02) AS SUBCODE02,
                TRIM(SUBCODE03) AS SUBCODE03, 
                TRIM(SUBCODE04) AS SUBCODE04,
                TRIM(SUBCODE05) AS SUBCODE05, 
                TRIM(SUBCODE06) AS SUBCODE06,
                TRIM(SUBCODE07) AS SUBCODE07, 
                TRIM(SUBCODE08) AS SUBCODE08,
                TRIM(SUBCODE09) AS SUBCODE09, 
                TRIM(SUBCODE10) AS SUBCODE10,
                TRIM(ITEMTYPEAFICODE) AS ITEMTYPEAFICODE,
                DSUBCODE05 AS NO_WARNA,
                TRIM(DSUBCODE02) || '-' || TRIM(DSUBCODE03) AS NO_HANGER,
                TRIM(ITEMDESCRIPTION) AS ITEMDESCRIPTION
            FROM 
                ITXVIEWKK 
            WHERE 
                PRODUCTIONORDERCODE LIKE '%$_noprod%'
            GROUP BY 
                PRODUCTIONORDERCODE,
                PROJECTCODE,
                ORDPRNCUSTOMERSUPPLIERCODE,
                SUBCODE01, 
                SUBCODE02,
                SUBCODE03, 
                SUBCODE04,
                SUBCODE05, 
                SUBCODE06,
                SUBCODE07, 
                SUBCODE08,
                SUBCODE09, 
                SUBCODE10,
                ITEMTYPEAFICODE,
                DSUBCODE05,
                DSUBCODE02,
                DSUBCODE03,
            ITEMDESCRIPTION";
    $query  = db2_exec($conn1, $sql);
    $dt     = db2_fetch_assoc($query);

    
    $sql2 = "SELECT 
                i.LEBAR,
                CASE
                    WHEN i2.GRAMASI_KFF IS NULL THEN i2.GRAMASI_FKF
                    ELSE
                        i2.GRAMASI_KFF
                END AS GRAMASI 
            FROM 
                ITXVIEWLEBAR i 
            LEFT JOIN ITXVIEWGRAMASI i2 ON i2.SALESORDERCODE = '$dt[PROJECTCODE]' AND i2.ORDERLINE = '$dt[ORDERLINE]'
            WHERE 
                i.SALESORDERCODE = '$dt[PROJECTCODE]' AND i.ORDERLINE = '$dt[ORDERLINE]'";
    $query2 = db2_exec($conn1, $sql2);
    $dt2    = db2_fetch_assoc($query2);

    $sql3 = "SELECT 
                DELIVERYDATE
            FROM 
                SALESORDERDELIVERY 
            WHERE 
                SALESORDERLINESALESORDERCODE = '$dt[PROJECTCODE]' AND SALESORDERLINEORDERLINE = '$dt[ORDERLINE]'";
    $query3 = db2_exec($conn1, $sql3);
    $dt3    = db2_fetch_assoc($query3);
    
    $sql4 = "SELECT 
                TRIM(LANGGANAN) AS PELANGGAN,
                TRIM(BUYER) AS BUYER
            FROM 
                ITXVIEW_PELANGGAN 
            WHERE 
                ORDPRNCUSTOMERSUPPLIERCODE = '$dt[ORDPRNCUSTOMERSUPPLIERCODE]' AND CODE = '$dt[PROJECTCODE]'";
    $query4 = db2_exec($conn1, $sql4);
    $dt4    = db2_fetch_assoc($query4);
    
    $sql5 = "SELECT 
                TRIM(WARNA) AS WARNA
            FROM 
                ITXVIEWCOLOR 
            WHERE 
                ITEMTYPECODE = '$dt[ITEMTYPEAFICODE]' 
                AND SUBCODE01 = '$dt[SUBCODE01]' 
                AND SUBCODE02 = '$dt[SUBCODE02]'
                AND SUBCODE03 = '$dt[SUBCODE03]' 
                AND SUBCODE04 = '$dt[SUBCODE04]'
                AND SUBCODE05 = '$dt[SUBCODE05]' 
                AND SUBCODE06 = '$dt[SUBCODE06]'
                AND SUBCODE07 = '$dt[SUBCODE07]' 
                AND SUBCODE08 = '$dt[SUBCODE08]'
                AND SUBCODE09 = '$dt[SUBCODE09]' 
                AND SUBCODE10 = '$dt[SUBCODE10]'";
    $query5 = db2_exec($conn1, $sql5);
    $dt5    = db2_fetch_assoc($query5);

    $sql6 = "SELECT 
                TRIM(EXTERNALREFERENCE) AS NO_PO
            FROM 
                ITXVIEW_KGBRUTO 
            WHERE 
                PROJECTCODE = '$dt[PROJECTCODE]' AND ORIGDLVSALORDERLINEORDERLINE = '$dt[ORDERLINE]'";
    $query6 = db2_exec($conn1, $sql6);
    $dt6    = db2_fetch_assoc($query6);

    $sql7_1 = "SELECT 
                    COUNT(*) AS JUMLAH
                FROM 
                    ITXVIEW_RESERVATION 
                WHERE 
                    PRODUCTIONORDERCODE = '$dt[PRODUCTIONORDERCODE]' AND ITEMTYPEAFICODE = 'KGF'";
    $query7_1 = db2_exec($conn1, $sql7_1);
    $cek_qty7_1 = db2_fetch_assoc($query7_1);

    if($cek_qty7_1['JUMLAH'] == "0"){
        $qty_order      = null;
        $qty_order_yard = null;
        $satuan_qty     = null;
    }else{
        $sql7_1 = "SELECT 
                    USEDUSERPRIMARYQUANTITY AS QTY_ORDER,
                    -- INITIALUSERPRIMARYQUANTITY AS QTY_ORDER,
                    USERSECONDARYQUANTITY AS QTY_ORDER_YARD,
                    CASE
                        WHEN TRIM(USERSECONDARYUOMCODE) = 'yd' THEN 'Yard'
                        WHEN TRIM(USERSECONDARYUOMCODE) = 'm' THEN 'Meter'
                        ELSE 'PCS'
                    END AS SATUAN_QTY
                FROM 
                    ITXVIEW_RESERVATION 
                WHERE 
                    PRODUCTIONORDERCODE = '$dt[PRODUCTIONORDERCODE]' AND ITEMTYPEAFICODE = 'KGF'";
        $query7_1   = db2_exec($conn1, $sql7_1);
        $dt7        = db2_fetch_assoc($query7_1);

        $qty_order      = $dt7['QTY_ORDER'];
        $qty_order_yard = $dt7['QTY_ORDER_YARD'];
        $satuan_qty     = $dt7['SATUAN_QTY'];
    }

    $q_roll     = db2_exec($conn1, "SELECT count(*) AS ROLL 
                                        FROM STOCKTRANSACTION 
                                        WHERE PRODUCTIONORDERCODE = '$dt[PRODUCTIONORDERCODE]' AND ITEMTYPECODE = 'KGF'
                                        GROUP BY PRODUCTIONORDERCODE, ITEMTYPECODE");
    $row_roll   = db2_fetch_assoc($q_roll);
    if (!empty($row_roll['ROLL'])) {
        $roll   = $row_roll['ROLL'];
    }else{
        $roll = '';
    }

    $query_kgbruto  = db2_exec($conn1, "SELECT SUM(USERPRIMARYQUANTITY) AS QTY_BRUTO FROM ITXVIEW_KGBRUTO WHERE PROJECTCODE = '$dt[PROJECTCODE]' AND ORIGDLVSALORDERLINEORDERLINE = '$dt[ORDERLINE]'");
    $row_kgbruto    = db2_fetch_assoc($query_kgbruto);
    if(!empty($row_kgbruto['QTY_BRUTO'])){
        $qty_bruto      = $row_kgbruto['QTY_BRUTO'];
    }else{
        $qty_bruto      = '';
    }

    $query_mesin_knt    = db2_exec($conn1, "SELECT 
                                                s.LOTCODE,
                                                a.VALUESTRING 
                                            FROM STOCKTRANSACTION s 
                                            LEFT JOIN PRODUCTIONDEMAND p ON p.CODE = s.LOTCODE 
                                            LEFT JOIN ADSTORAGE a ON a.UNIQUEID = p.ABSUNIQUEID AND a.NAMENAME = 'MachineNo'
                                            WHERE s.PRODUCTIONORDERCODE = '$_noprod_'");
    $row_mesin_knt      = db2_fetch_assoc($query_mesin_knt);
    if(!empty($row_mesin_knt['VALUESTRING'])){
        $mesinknt   = $row_mesin_knt['VALUESTRING'];
    }else{
        $mesinknt   = '';
    }

    $query_br1       = db2_exec($conn1, "SELECT
                                            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
                                            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP1,
                                            TRIM(SUFFIXCODE) AS SUFFIXCODE
                                        FROM
                                            PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
                                        WHERE
                                            PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' 
                                            AND PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$_noprod_' 
                                        ORDER BY
                                            PRODUCTIONRESERVATION.GROUPLINE ASC 
                                            LIMIT 1");
    $row_br1        = db2_fetch_assoc($query_br1);
    
    $query_br2       = db2_exec($conn1, "SELECT
                                            TRIM( PRODUCTIONRESERVATION.PRODUCTIONORDERCODE ) AS PRODUCTIONORDERCODE,
                                            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP2 
                                        FROM
                                            PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
                                        WHERE
                                            PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' 
                                            AND PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$_noprod_' 
                                        ORDER BY
                                            PRODUCTIONRESERVATION.GROUPLINE DESC 
                                            LIMIT 1");
    $row_br2        = db2_fetch_assoc($query_br2);

    
    //Menampung data yang dihasilkan
    $json = array(
        'PRODUCTIONORDERCODE'   => $dt['PRODUCTIONORDERCODE'],
        'DEAMAND'               => $dt['DEMAND'],
        'ORDERLINE'             => $dt['ORDERLINE'],
        'PELANGGAN'             => $dt4['PELANGGAN'],
        'BUYER'                 => $dt4['BUYER'],
        'PROJECTCODE'           => $dt['PROJECTCODE'],
        'NO_PO'                 => $dt6['NO_PO'],
        'NO_HANGER'             => $dt['NO_HANGER'],
        'ITEMDESCRIPTION'       => $dt['ITEMDESCRIPTION'],
        'DELIVERYDATE'          => $dt3['DELIVERYDATE'],
        'LEBAR'                 => $dt2['LEBAR'],
        'GRAMASI'               => $dt2['GRAMASI'],
        'WARNA'                 => $dt5['WARNA'],
        'NO_WARNA'              => $dt['NO_WARNA'],
        'QTY_ORDER'             => $qty_order,
        'QTY_ORDER_YARD'        => $qty_order_yard,
        'SATUAN_QTY'            => $satuan_qty,
        'ROLL'                  => $roll,
        'QTY_BRUTO'             => $qty_bruto,
        'MESINKNT'              => $mesinknt,
        'BONRESEP1'             => $row_br1['BONRESEP1'],
        'SUFFIX'                => $row_br1['SUFFIXCODE'],
        'BONRESEP2'             => $row_br2['BONRESEP2']
    );
    
    //Merubah data kedalam bentuk JSON
    header('Content-Type: application/json');
    echo json_encode($json);
?>