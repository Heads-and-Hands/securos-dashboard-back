<?php
declare(strict_types=1);

namespace App\Models\Common;

use Carbon\Carbon;
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
 * @property string|null $approval_at
 * @property string|null $creation_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereApprovalAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCamera whereCreationAt($value)
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
    public const NOT_IN_OPERATION = 20;
    public const UNKNOWN = 30;
    public const DEFECT = 40;

    static public array $statuses = [
        self::REGULAR_CAMERA  => 'regularCamera',
        self::NOT_IN_OPERATION => 'notInOperation',
        self::UNKNOWN => 'unknown',
        self::DEFECT => 'defect',
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
        'status_exploitation', 'passport', 'status', 'approval_at', 'creation_at'
    ];

    public function getApprovalAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->toIso8601String();
        }
    }

    public function getCreationAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->toIso8601String();
        }
    }

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
            return json_decode($passport);
        }
    }

    public function setTypeAttribute($type): int
    {
        if ($type) {
            return $this->attributes['type'] = self::PTZ;
        }
        return $this->attributes['type'] = self::NOT_A_PTZ;
    }

    public function setPassportAttribute($passport)
    {
        if ($passport) {
            return $this->attributes['passport'] = json_encode($passport);
        }
        return $this->attributes['passport'] = null;
    }

    public function getStatusExploitationAttribute($status): string
    {
        return static::$statusesExploitation[$status];
    }
}
