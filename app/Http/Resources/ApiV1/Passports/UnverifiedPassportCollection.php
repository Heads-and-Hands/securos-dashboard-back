<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\Passports;

use App\Http\Resources\ApiV1\BaseResourceCollection;

class UnverifiedPassportCollection extends BaseResourceCollection
{
    public $collection = UnverifiedPassportResource::class;
}
