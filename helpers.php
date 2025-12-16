<?php

function formatDateTime($date, $format = "Y-m-d H:i:s")
{
    if ($date === null || $date === "" ) {
        return null;
    }

    if ($date instanceof DateTime) {
        return $date->format($format);
    }

    try {
        $dt = new DateTime($date);
        return $dt->format($format);
    } catch (Exception $e) {
        return null;
    }
}


function escapeString($str)
{
    if ($str === null) {
        return null;
    }

    $str = trim($str);
    $str = str_replace("'", "''", $str);
    $str = preg_replace('/[^\PC\s]/u', '', $str);

    return $str;
}
