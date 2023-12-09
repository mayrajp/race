<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Http\Services\CarService;

class CarController extends Controller
{
    private CarService $service;

    public function __construct()
    {   
        $this->service = new CarService();
    }

    public function index()
    {
        $response = $this->service->index();

        return response()->json($response->data, $response->code);
    }

   
    public function store(CarRequest $request)
    {
        $response = $this->service->store($request);

        return response()->json($response->data, $response->code);
    }

   
    public function show(int $id)
    {
        $response = $this->service->show($id);

        return response()->json($response->data, $response->code);
    }

   
    public function update(CarRequest $request, int $id)
    {
        $response = $this->service->update($request, $id);

        return response()->json($response->data, $response->code);
    }

    public function destroy(int $id)
    {
        $response = $this->service->destroy($id);

        return response()->json($response->data, $response->code);
    }
}
