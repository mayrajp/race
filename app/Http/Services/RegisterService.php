<?php

namespace App\Http\Services;

use App\Classes\BaseServiceResponse;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterService extends BaseService
{
    public function register(RegisterRequest $request) : BaseServiceResponse
    {
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        
        return $this->success([$success], JsonResponse::HTTP_CREATED);

    }

    public function login(Request $request) : BaseServiceResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
   
            return $this->success([$success], JsonResponse::HTTP_OK);
        } 
        else{ 
            return $this->error([] , JsonResponse::HTTP_UNAUTHORIZED);
        } 
    }
    
}