<?php

namespace App\Http\Controllers\Api\Mobile\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Managers\PreferenceManager;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementController extends ApiController
{
    use ApiResponder, PreferenceManager;

    public function index()
    {
        return ApiResponder::success(
            $this->fetchAnnouncements(),
            'Successfully [GET] Announcement',
            Response::HTTP_CREATED
        );
    }
}
