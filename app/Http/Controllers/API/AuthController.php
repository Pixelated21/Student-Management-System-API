<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Authentication\LoginRequest;
use App\Models\Administrator;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HttpResponses;

class AuthController extends Controller
{
    use HttpResponses;

    private function generateToken($user,int $daysTillExpiry = 1){
        $token = $user?->createToken('token',['*'],Carbon::now()->addDays($daysTillExpiry))->plainTextToken;
        return $token;
    }

    public function login(LoginRequest $request)
    {
        $inputData = $request->validated();

        $admin = Administrator::where('username','=',$inputData['username'])->first() ?? false;

        if(!$admin || !Hash::check($inputData['password'],$admin->password)){
            return $this->error('','Invalid credentials',Response::HTTP_UNAUTHORIZED);
        }

        $token = $this->generateToken($admin);
        $cookie = cookie('jwt',$token,60*24);
        $admin->userLoggedIn(true);

        return $this->success([
            'user' => $admin,
            'token' => $token,
        ],'User logged in successfully',Response::HTTP_OK)->withCookie($cookie);

    }

    public function logout(Request $request)
    {
        $request->user()->userLoggedIn(false);
        $request->user()->currentAccessToken()->delete();
        return $this->success('','User logged out successfully',Response::HTTP_OK);
    }
}
