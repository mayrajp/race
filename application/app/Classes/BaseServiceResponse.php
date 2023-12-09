<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class BaseServiceResponse
{
    public bool $success;
    public int $code;
    public array|ResourceCollection|JsonResource|Model|EloquentCollection|BaseCollection|null $data = [];
    public string $message;

    public function __construct($success, $code, $data, $message) {
        if (!isset($message)) {
            if ($success)
                $message = __('validation.success');
            else
                $message = __('validation.error');

        }
        $this->success = $success;
        $this->code = $code;
        $this->data = [
            'data' => $data,
            'message' => $message
        ];
        $this->message = $message;
    }
}
