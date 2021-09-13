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
    $result =  $nilai === null ? "-" : date('H:i:s', strtotime($nilai));
    return $result;
}

function tanggalNilai($nilai)
{
    return date("N", strtotime($nilai));
}

function selisih($awal, $akhir)
{
    // Master mangkat
    if ($awal == null) {
        return "-";
    } else {
        $masterJam = strtotime($awal);
        $absenJam = strtotime($akhir);
        if ($absenJam < $masterJam) {
            return 0;
        } else {
            return $absenJam - $masterJam; 
        }
       
    }
}

function selisihMenit($nilai) : int
{
    $nilaiToMenit = (int) $nilai / 60;
    
    return (int)($nilaiToMenit);
}

function keterangan($awal, $akhir, $status, $kodeShift)
{
    $jamJadwal = strtotime($awal);
    $jamAbsen = strtotime($akhir);

    if ($jamJadwal) {
       if ($kodeShift === "B") {
            $result = "Jadwal Belum Terinput!";
       }  else {
            if ($jamAbsen > $jamJadwal && $status == 1) {
                $result = "Datang Terlambat";
            } else if ($jamAbsen < $jamJadwal && $status == 2) {
                $result = "Pulang Cepat";
            } else {
                $result = "-";
            }
       }
    } else {
        $result = "-";
    }

    return $result;
}

function status($nilai)
{
    return $nilai == 1 ? "Aktif" : "Tidak aktif";
}

function hari($nilai)
{
    $hari =  [
        1 => "Senin",
        2 => "selasa",
        3 => "Rabu",
        4 => "Kamis",
        5 => "Jum'at",
        6 => "Sabtu",
        7 => "Minggu"
    ];

    return $hari[$nilai];
}