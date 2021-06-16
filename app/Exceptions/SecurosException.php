<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class SecurosException extends Exception
{
    public function render($request): JsonResponse
    {
        $data = json_decode($this->getMessage());
        return response()->json([
           'message' => $data->message ?? $this->getMessage()
        ], $data->status ?? 502);
    }
}
