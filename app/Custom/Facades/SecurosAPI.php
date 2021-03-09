<?php
declare(strict_types=1);

namespace App\Custom\Facades;

use Illuminate\Support\Facades\Facade;

class SecurosAPI extends Facade {
    protected static function getFacadeAccessor() {
    	return 'App\Custom\Contracts\SecurosAPI'; 
    }
}