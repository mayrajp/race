<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverRequest;
use App\Http\Services\DriverService;

class DriverController extends Controller
{
    private DriverService $service;

    public function __construct()
    {   
        $this->service = new DriverService();
    }

    public function index()
    {
        $response = $this->service->index();

        return response()->json($response->data, $response->code);
    }

   
    public function store(DriverRequest $request)
    {
        $response = $this->service->store($request);

        return response()->json($response->data, $response->code);
    }

   
    public function show(int $id)
    {
        $response = $this->service->show($id);

        return response()->json($response->data, $response->code);
    }

   
    public function update(DriverRequest $request, int $id)
    {
        $response = $this->service->update($request, $id);

        return response()->json($response->data, $response->code);
    }
}
