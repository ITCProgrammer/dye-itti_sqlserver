<?php
    session_start();
    include_once "koneksi.php";
    $_noprod    = sprintf("%08d", $_GET['noprod']);
    $query_br1       = db2_exec($conn2, "SELECT
                                            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
                                            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP1,
                                            TRIM(SUFFIXCODE) AS SUFFIXCODE
                                        FROM
                                            PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
                                        WHERE
                                            -- (PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' OR PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFF')
                                            (PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFF' AND PRODUCTIONRESERVATION.PRODRESERVATIONLINKGROUPCODE  = 'CBL1')
                                            -- PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD'
                                            AND PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$_noprod' 
                                        ORDER BY
                                            PRODUCTIONRESERVATION.GROUPLINE ASC LIMIT 1");
    $row_br1        = db2_fetch_assoc($query_br1);
    if(!empty($row_br1['BONRESEP1'])){
        $bonresep1      = $row_br1['BONRESEP1'];
    }else{
        $bonresep1      = '';
    }
    if(!empty($row_br1['SUFFIXCODE'])){
        $suffixcode     = $row_br1['SUFFIXCODE'];
    }else{
        $suffixcode     = '';
    }

    $query_br2      = db2_exec($conn2, "SELECT
                                            TRIM( PRODUCTIONRESERVATION.PRODUCTIONORDERCODE ) AS PRODUCTIONORDERCODE,
                                            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP2 
                                        FROM
                                            PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
                                        WHERE
                                            -- (PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' OR PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFF')
                                            (PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFF' AND PRODUCTIONRESERVATION.PRODRESERVATIONLINKGROUPCODE  = 'CBL1')
                                            -- PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD'
                                            AND PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$_noprod' 
                                        ORDER BY
                                            PRODUCTIONRESERVATION.GROUPLINE DESC LIMIT 1");
    $row_br2        = db2_fetch_assoc($query_br2);
    if(!empty($row_br2['BONRESEP2'])){
        $bonresep2      = $row_br2['BONRESEP2'];
    }else{
        $bonresep2      = '';
    }

    //Menampung data yang dihasilkan
    $json = array(
        'CB_BONRESEP1'             => $bonresep1,
        'CB_SUFFIX'                => $suffixcode,
        'CB_BONRESEP2'             => $bonresep2
    );

    header('Content-Type: application/json');
    echo json_encode($json);