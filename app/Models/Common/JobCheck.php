<?php

namespace App\Models\Common;

use Carbon\Carbon;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Common\JobCheck
 *
 * @property int $id
 * @property string $name
 * @property bool $done
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|JobCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCheck whereDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCheck whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCheck whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JobCheck extends Model
{
    use Timestamp;

    protected $fillable = ['name', 'done'];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->toIso8601String();
    }
}
