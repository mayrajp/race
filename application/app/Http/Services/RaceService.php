<?php

namespace App\Http\Services;

use App\Classes\BaseServiceResponse;
use App\Http\Requests\AttachDriversRequest;
use App\Http\Requests\RaceRequest;
use App\Http\Resources\RaceResource;
use App\Models\Driver;
use App\Models\Race;
use App\Models\Speedway;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;

class RaceService extends BaseService
{
    public function index(): BaseServiceResponse
    {
        $race = Race::all();

        return $this->success(RaceResource::collection($race), JsonResponse::HTTP_OK);
    }


    public function store(RaceRequest $request): BaseServiceResponse
    {
        $data = $request->all();

        $speedway = Speedway::find($data['speedway_id'])->first();

        if ($speedway->in_maintenance == true || $speedway->is_active == false) {
            return $this->error(['error' => 'Pista de corrida encontra-se indisponível.'], JsonResponse::HTTP_BAD_REQUEST);
        }
        $startDate = Carbon::parse($data['start_date'])->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($data['end_date'])->format('Y-m-d H:i:s');

        $race = new Race([
            'name' => $data['name'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'prize_value' => $data['prize_value'],
            'is_canceled' => $data['is_canceled'],
            'maximum_number_of_drivers' => $data['maximum_number_of_drivers']
        ]);

        $race->speedway()->associate($speedway);

        $race->save();

        return $this->success(new RaceResource($race), JsonResponse::HTTP_CREATED);
    }


    public function show(int $id)
    {
        $race = Race::findOrFail($id)->first();

        return $this->success(new RaceResource($race), JsonResponse::HTTP_OK);
    }


    public function update(RaceRequest $request, int $id)
    {
        $data = $request->all();

        $race = Race::findOrFail($id)->first();
        $speedway = Speedway::find($data['speedway_id'])->first();
        $startDate = Carbon::parse($data['start_date'])->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($data['end_date'])->format('Y-m-d H:i:s');

        $race->name = $data['name'];
        $race->start_date = $startDate;
        $race->end_date = $endDate;
        $race->prize_value = $data['prize_value'];
        $race->is_canceled = $data['is_canceled'];
        $race->maximum_number_of_drivers = $data['maximum_number_of_drivers'];
        $race->speedway()->associate($speedway);

        $race->update();

        return $this->success(new RaceResource($race), JsonResponse::HTTP_OK);
    }


    public function cancelRace(int $id)
    {
        $race = Race::findOrFail($id)->first();

        $race->is_canceled = true;

        $race->save();

        return $this->success([], JsonResponse::HTTP_OK);
    }

    public function attachDrivers(AttachDriversRequest $request)
    {
        $data = $request->all();

        try {

            $amount = count($data['drivers']);

            $race = Race::find($data['race_id']);

            if ($race->drivers()->count() + $amount > $race->maximum_number_of_drivers) {

                return $this->error(['error' => 'Limite de participantes da corrida ultrapassado'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            foreach ($data['drivers'] as $driverId) {

                $driver = Driver::findOrFail(['id' => $driverId])->first();

                $hasCar = false;

                foreach ($driver->cars as $car) {
                    if (in_array($race->speedway->type->value, json_decode($car->speedway_types))) {
                        $hasCar = true;
                    }
                }

                if (!$hasCar) {
                    return $this->error(['error' => 'Competidor ' . $driver->name . ' não tem veículo adequado para a pista.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            foreach ($data['drivers'] as $driverId) {
                if (!$race->drivers()->where('driver_id', $driverId)->exists()) {
                    $race->drivers()->attach($driverId);
                }
            }

            return $this->success([], JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            return $this->error(['error' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function detachDrivers(AttachDriversRequest $request)
    {
    }
}
