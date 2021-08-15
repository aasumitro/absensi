<?php

if (! function_exists('jwt_decode')) {
    function jwt_decode(string $jwt): Object
    {
        return (object) \Tymon\JWTAuth\Facades\JWTAuth::manager()
            ->getJWTProvider()
            ->decode($jwt);
    }
}
