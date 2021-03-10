<?php
declare(strict_types=1);

namespace App\Models\ApiV1\Filter;

use App\Http\Requests\ApiV1\VideoCamera\Filter\VideoCameraFilterRequest;
use App\Models\ApiV1\VideoCamera;
use App\Models\QueryFilter;

class VideoCameraFilter extends QueryFilter
{
    public function __construct(VideoCameraFilterRequest $request)
    {
        parent::__construct($request);
    }

    public function statusCameras($value): void
    {
        if ($value) {
            $value = explode(',', $value);
            foreach ($value as $status) {
                $statuses[] = array_flip(VideoCamera::$statuses)[$status];
            }
            $this->builder->whereIn('status', $statuses ?? []);
        }
    }

    public function rangeOfIpCameras($value): void
    {
        if ($value) {
            $value = explode('-', $value);
            $data[] = sprintf('%u', ip2long($value[0]));
            $data[] = sprintf('%u', ip2long($value[1]));
            $this->builder->whereBetween('ip_decode', $data);
        }
    }

    public function statusExploitation($value): void
    {
        if ($value) {
            $value = explode(',', $value);
            foreach ($value as $status) {
                $statuses[] = array_flip(VideoCamera::$statuses)[$status];
            }
            $this->builder->whereIn('status_exploitation', $statuses ?? []);
        }
    }

    public function statusExploitationSort($value): void
    {
        if ($value) {
            $this->builder->orderBy('status_exploitation', $value);
        }
    }

    public function statusCamerasSort($value): void
    {
        if ($value) {
            $this->builder->orderBy('status', $value);
        }
    }

    public function nameSort($value): void
    {
        if ($value) {
            $this->builder->orderBy('name', $value);
        }
    }

    public function ipCamerasSort($value): void
    {
        if ($value) {
            $this->builder->orderBy('ip_decode', $value);
        }
    }

    public function ipServerSort($value): void
    {
        if ($value) {
            $this->builder->orderBy('ip_server_decode', $value);
        }
    }

    public function q($value): void
    {
        $this->builder->where('name', 'ilike', '%' . trim($value) . '%')
                ->orWhere('ip', 'ilike', '%' . trim($value) . '%')
                ->orWhere('ip_server', 'ilike', '%' . trim($value) . '%');
    }
}