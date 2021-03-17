<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Common\JobCheck;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function checkJob(): JsonResponse
    {
        $jobCheck = JobCheck::select(['done'])
            ->orderByDesc('id')
            ->first();

        return response()->json(['checkJob' => $jobCheck->done ?? null, 'start' => $jobCheck->created_at ?? null], 200);
    }
}
