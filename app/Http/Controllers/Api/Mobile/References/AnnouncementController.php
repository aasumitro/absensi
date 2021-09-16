<?php

namespace App\Http\Controllers\Api\Mobile\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Managers\ReferenceManager;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementController extends ApiController
{
    use ApiResponder, ReferenceManager;

    public function index()
    {
        return ApiResponder::success(
            $this->fetchAnnouncements(),
            'Successfully [GET] Announcement',
            Response::HTTP_CREATED
        );
    }
}
