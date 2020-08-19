<?php
date_default_timezone_set('UTC');

function generate_token($kode, $password)
{
    $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
    $signataure = hash_hmac('sha256', $kode."&".$tStamp, $password, true);
    
    $encodeSignature = base64_encode($signataure);
    return $encodeSignature;
}

function absensi($status)
{
    return $status == 1 ? "Masuk" : $status == 2 ?  "Keluar" : '';
}

function tanggal($nilai)
{
    return date('Y-m-d', strtotime($nilai));
}

function waktu($nilai)
{
    return date('H:i:s', strtotime($nilai));
}

