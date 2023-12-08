<?php

namespace App\Http\Services;

use App\Classes\BaseServiceResponse;
use App\Http\Requests\SpeedwayRequest;
use App\Http\Resources\SpeedwayResource;
use App\Models\Speedway;
use Illuminate\Http\JsonResponse;

class SpeedwayService extends BaseService
{
    public function index(): BaseServiceResponse
    {
        $speedways = Speedway::all();

        return $this->success(SpeedwayResource::collection($speedways), JsonResponse::HTTP_OK);
    }


    public function store(SpeedwayRequest $request): BaseServiceResponse
    {
        $speedway = Speedway::create(
            $request->all()
        );

        return $this->success( new SpeedwayResource($speedway), JsonResponse::HTTP_CREATED);
    }


    public function show(int $id): BaseServiceResponse
    {
        $speedway = Speedway::findOrFail($id);

        return $this->success(new SpeedwayResource($speedway), JsonResponse::HTTP_OK);

    }


    public function update(SpeedwayRequest $request, int $id): BaseServiceResponse
    {
        $speedway = Speedway::findOrFail($id);

        $speedway->fill($request->all())->save();

        return $this->success(new SpeedwayResource($speedway), JsonResponse::HTTP_OK);

    }
}
