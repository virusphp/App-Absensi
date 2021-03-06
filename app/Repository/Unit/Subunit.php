<?php

namespace App\Repository\Unit;
use DB;

class Subunit
{
    public function getSubunit()
    {
        return DB::connection('sqlsrv_simrs')->table('sub_unit')->select(
                'kd_sub_unit','nama_sub_unit'
            )
            ->get();
    }
}