<?php
declare(strict_types=1);

namespace App\Models\Common;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

/**
 * App\Models\Common\VideoCamera
 *
 * @property int $id
 * @property string $name
 * @property string $ip
 * @property int $type
 * @property string $ip_decode
 * @property string $ip_server
 * @property string $ip_server_decode
 * @property int $status
 * @property int $status_exploitation
 * @property string|null $passport
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera query()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereIpDecode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereIpServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereIpServerDecode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereStatusExploitation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class VideoCamera extends Model
{
    use HasFactory;
    use Timestamp;

    public const ASC = 'asc';
    public const DESC = 'desc';

    static public array $sort = [
        self::ASC  => 'asc',
        self::DESC => 'desc',
    ];

    public const PTZ = 10;
    public const NOT_A_PTZ = 20;

    static public array $types = [
        self::PTZ  => 'PTZ',
        self::NOT_A_PTZ => 'notPTZ',
    ];

    #TODO упорядочить список после того как утвердят тз
    public const REGULAR_CAMERA = 10;
    public const DEFECT = 20;
    public const NOT_IN_OPERATION = 30;
    public const UNKNOWN = 40;

    static public array $statuses = [
        self::REGULAR_CAMERA  => 'regularCamera',
        self::DEFECT => 'defect',
        self::NOT_IN_OPERATION => 'notInOperation',
        self::UNKNOWN => 'unknown',
    ];

    public const INTRODUCED = 10;
    public const NOT_VERIFIED = 20;
    public const NOT_FILLED = 30;

    static public array $statusesExploitation = [
        self::INTRODUCED  => 'introduced',
        self::NOT_VERIFIED => 'notVerified',
        self::NOT_FILLED => 'notFilled',
    ];

    protected $fillable = [
        'id', 'name', 'ip', 'type', 'ip_decode', 'ip_server', 'ip_server_decode',
        'status_exploitation', 'passport'
    ];

    public function getTypeAttribute($type): string
    {
        return static::$types[$type];
    }

    public function getStatusAttribute($status): string
    {
        return static::$statuses[$status];
    }

    public function getIpDecodeAttribute($ip): string
    {
        return long2ip($ip);
    }

    public function setIpDecodeAttribute($ip): void
    {
        $ip = sprintf('%u', ip2long($ip));
        $this->attributes['ip_decode'] = $ip;
    }

    public function getIpServerDecodeAttribute($ip): string
    {
        return long2ip($ip);
    }

    public function setIpServerDecodeAttribute($ip): void
    {
        $ip = sprintf('%u', ip2long($ip));
        $this->attributes['ip_server_decode'] = $ip;
    }

    public function getPassportAttribute($passport)
    {
        if ($passport) {
            return json_encode($passport);
        }
    }

    public function setPassportAttribute($passport)
    {
        return json_decode($passport);
    }
}
