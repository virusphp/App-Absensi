<?php

namespace App\Repository\Setup;

use DB;

class Setup
{
	public function checking()
	{
	    return DB::table('setup_app')->select('cek_version')
			->first();
	}
}