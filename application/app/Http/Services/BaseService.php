<?php

namespace App\Http\Services;

use Illuminate\Http\JsonResponse;
use App\Classes\BaseServiceResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class BaseService
{
    protected $model;

    public function success(array|ResourceCollection|JsonResource|Model|EloquentCollection|BaseCollection|null $data = [], int|null $code = JsonResponse::HTTP_OK, string $message = null): BaseServiceResponse
    {
        $message = is_null($message) ? __('validation.success') : $message;
        return new BaseServiceResponse(
            true,
            $code,
            $data,
            $message
        );
    }

    public function error(array|null $errors = [], int|null $code = JsonResponse::HTTP_BAD_REQUEST, string|null $message = null): BaseServiceResponse
    {
        $message = is_null($message) ? __('validation.error') : $message;
        return new BaseServiceResponse(
            false,
            $code,
            $errors,
            $message
        );
    }
}
