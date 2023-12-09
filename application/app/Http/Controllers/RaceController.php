<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachDriversRequest;
use App\Http\Requests\RaceRequest;
use App\Http\Services\RaceService;

class RaceController extends Controller
{
   
    private RaceService $service;

    public function __construct()
    {   
        $this->service = new RaceService();
    }

    public function index()
    {
        $response = $this->service->index();

        return response()->json($response->data, $response->code);
    }

   
    public function store(RaceRequest $request)
    {
        $response = $this->service->store($request);

        return response()->json($response->data, $response->code);
    }

   
    public function show(int $id)
    {
        $response = $this->service->show($id);

        return response()->json($response->data, $response->code);
    }

   
    public function update(RaceRequest $request, int $id)
    {
        $response = $this->service->update($request, $id);

        return response()->json($response->data, $response->code);
    }

    public function cancelRace(int $id)
    {
        $response = $this->service->cancelRace($id);

        return response()->json($response->data, $response->code);
    }

    public function attachDrivers(AttachDriversRequest $request)
    {
        $response = $this->service->attachDrivers($request);

        return response()->json($response->data, $response->code);
    }
}
