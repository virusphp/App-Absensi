<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Access extends Authenticatable
{
    protected $connection = 'sqlsrv_sms';
    protected $table = "access";
    protected $guard = 'access';
}
