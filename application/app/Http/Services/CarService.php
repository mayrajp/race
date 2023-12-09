<?php

namespace App\Http\Services;

use App\Classes\BaseServiceResponse;
use App\Http\Requests\CarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;

class CarService extends BaseService
{
    public function index(): BaseServiceResponse
    {
        $car = Car::all();

        return $this->success(CarResource::collection($car));
    }


    public function store(CarRequest $request): BaseServiceResponse
    {
        $data = $request->all();

        $driver = Driver::findOrFail([$data['driver_id']])->first();

        $car = new Car([
            'model' => $data['model'],
            'brand' => $data['brand'],
            'year' => $data['year'],
            'color' => $data['color'],
            'speedway_types' => json_encode($data['speedway_types']),
        ]);

        $car->driver()->associate($driver);

        $car->save();

        return $this->success(new CarResource($car), JsonResponse::HTTP_CREATED);
    }


    public function show(int $id): BaseServiceResponse
    {
        $car = Car::findOrFail($id);

        return $this->success(new CarResource($car));
    }


    public function update(CarRequest $request, int $id): BaseServiceResponse
    {
        $data = $request->all();

        $car = Car::findOrFail($id)->first();

        $driver = Driver::findOrFail([$data['driver_id']])->first();

        $car->model = $data['model'];
        $car->brand = $data['brand'];
        $car->year = $data['year'];
        $car->color = $data['color'];
        $car->speedway_types = json_encode($data['speedway_types']);
        $car->driver()->associate($driver);

        $car->update();

        return $this->success(new CarResource($car));
    }

    public function destroy(int $id): BaseServiceResponse
    {
        $car = Car::findOrFail($id);

        $car->delete();

        return $this->success([], JsonResponse::HTTP_OK);
    }
}
