<?php

namespace App\Http\Controllers\Api\Mobile\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Managers\ReferenceManager;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class AbsentTypeController extends ApiController
{
    use ApiResponder, ReferenceManager;

    public function index()
    {
        return ApiResponder::success(
            $this->fetchAbsentTypes(),
            'Successfully [GET] Absent Type',
            Response::HTTP_CREATED
        );
    }
}
