<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpeedwayRequest;
use App\Http\Services\SpeedwayService;

class SpeedwayController extends Controller
{
    
    private SpeedwayService $service;

    public function __construct()
    {   
        $this->service = new SpeedwayService();
    }

    public function index()
    {
        $response = $this->service->index();

        return response()->json($response->data, $response->code);
    }

   
    public function store(SpeedwayRequest $request)
    {
        $response = $this->service->store($request);

        return response()->json($response->data, $response->code);
    }

   
    public function show(int $id)
    {
        $response = $this->service->show($id);

        return response()->json($response->data, $response->code);
    }

   
    public function update(SpeedwayRequest $request, int $id)
    {
        $response = $this->service->update($request, $id);

        return response()->json($response->data, $response->code);
    }

}
