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
    return $status == 1 ? "Masuk" : "Keluar" ;
}

function tanggal($nilai)
{
    return date('Y-m-d', strtotime($nilai));
}

function generateKey($nilai)
{
    return $nilai == null ? "-" : $nilai;
}

function waktu($nilai)
{
    return date('H:i:s', strtotime($nilai));
}

function tanggalNilai($nilai)
{
    return date("N", strtotime($nilai));
}

function selisih($awal, $akhir)
{
    // Master mangkat
    $masterJam = new DateTime($awal);
    $absenJam = new DateTime($akhir);
    return $absenJam->diff($masterJam)->format('%h:%i:%s');
}

function keterangan($awal, $akhir, $status)
{
    $nilaiAwal = strtotime($awal);
    $nilaiAkhir = strtotime($akhir);

    if ($nilaiAkhir > $nilaiAwal && $status == 1) {
        $result = "Datang Terlambat";
    } else if ($nilaiAkhir < $nilaiAwal && $status == 2) {
        $result = "Pulang Cepat";
    } else {
        $result = "-";
    }

    return $result;
}

function status($nilai)
{
    return $nilai == 1 ? "Aktif" : "Tidak aktif";
}

