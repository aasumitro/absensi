<?php

namespace App\Http\Controllers\Api\Mobile\Submissions;

use App\Http\Controllers\Api\ApiController;
use App\Traits\ApiResponder;

class SubmissionIssuedController extends ApiController
{
    use ApiResponder;

    public function index()
    {
        try {
            // return ApiResponder::success();
        } catch (\Exception $exception) {
            // return ApiResponder::error();
        }
    }
}
