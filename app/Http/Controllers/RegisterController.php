<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Services\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private RegisterService $registerService;
   
    public function __construct()
    {
        $this->registerService = new RegisterService();
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->registerService->register($request);

        return response()->json($response->data, $response->code);
    }

   
    public function login(Request $request)
    {
        $response = $this->registerService->login($request);

        return response()->json($response->data, $response->code);
    }

}
