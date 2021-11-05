<?php

namespace App\Repository\Emulator;
use DB;

class Emulator
{
    public function getEmulator()
    {
        return DB::table('setup_app')->select(
                'cek_emulator','cek_version'
            )
            ->orderBy('cek_version', 'asc')
            ->get();
    }
}