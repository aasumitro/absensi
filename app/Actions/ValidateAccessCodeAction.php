<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ValidateAccessCodeAction
{
    /**
     * @throws ValidationException
     */
    public function execute(Request $request): array
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

        return [
            'token' => $jwt,
            'type' => 'bearer',
            'expires_in' => JWT_TTL_IN_SECOND
        ];
    }
}
