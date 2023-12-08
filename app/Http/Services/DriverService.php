<?php

namespace App\Http\Services;

use App\Classes\BaseServiceResponse;
use App\Http\Requests\DriverRequest;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;

class DriverService extends BaseService
{
    public function index(): BaseServiceResponse
    {
        $drivers = Driver::all();

        return $this->success(DriverResource::collection($drivers), JsonResponse::HTTP_OK);
    }


    public function store(DriverRequest $request): BaseServiceResponse
    {
        $driver = Driver::create(
            $request->all()
        );

        return $this->success( new DriverResource($driver), JsonResponse::HTTP_CREATED);
    }


    public function show(int $id): BaseServiceResponse
    {
        $driver = Driver::findOrFail($id);

        return $this->success(new DriverResource($driver), JsonResponse::HTTP_OK);

    }


    public function update(DriverRequest $request, int $id): BaseServiceResponse
    {
        $driver = Driver::findOrFail($id);

        $driver->fill($request->all())->save();

        return $this->success(new DriverResource($driver), JsonResponse::HTTP_OK);

    }

    public function destroy(int $id): BaseServiceResponse
    {
        $driver = Driver::findOrFail($id);

        $driver->delete();

        return $this->success([], JsonResponse::HTTP_OK);


    }
}