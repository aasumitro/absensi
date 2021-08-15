<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class ValidateAccessCodeAction
{
    /**
     * @throws ValidationException
     */
    public function execute(Request $request)
    {
        $user = User::where([
            'username' => $request->username
        ])->firstOrFail();

        // when device id is not empty
        // && device id given is not equals
        // with registered device id
         if ($user->phone_id && ($user->phone_id !== $request->phone_id)) {
             throw ValidationException::withMessages([
                 'action' => "NEW_DEVICE",
             ]);
        }

        // when given code not match
        if (!$user->isCodeValid($request->password)) {
            throw ValidationException::withMessages([
                'action' => "CODE_NOT_MATCH",
            ]);
        }

        $jwt = auth('api')->setTTL(JWT_TTL_IN_MINUTE)->login($user);
        dd($jwt);
//        auth('api')->setTTL(JWT_TTL_IN_MINUTE)->attempt(
//            $request->only('username', 'password')
//        );

//        return [
//            'token' => $token,
//            'type' => 'bearer',
//            'expires_in' => JWT_TTL_IN_SECOND
//        ];
    }
}
