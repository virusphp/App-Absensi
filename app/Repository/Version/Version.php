<?php

namespace App\Repository\Version;

use DB;

class Version
{
	public function getVersion($params)
	{
	    return DB::table('version')->select('code_version', 'name_version')
			->where('code_version', $params->code_version)
			->first();
	}
}