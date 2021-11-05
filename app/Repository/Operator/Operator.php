<?php

namespace App\Repository\Operator;
use DB;

class Operator
{
    public function getOperator()
    {
        return DB::table('operator_seluler')->select(
                'kode_operator','nama_operator'
            )
            ->orderBy('nama_operator', 'asc')
            ->get();
    }
}