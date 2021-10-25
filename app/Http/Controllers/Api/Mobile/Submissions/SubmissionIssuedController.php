<?php

namespace App\Http\Controllers\Api\Mobile\Submissions;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\ApplyNewSubmissionRequest;
use App\Models\AbsentType;
use App\Models\Managers\AttachmentManager;
use App\Models\Managers\SubmissionManager;
use App\Models\Submission;
use App\Traits\ApiResponder;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class SubmissionIssuedController extends ApiController
{
    use ApiResponder, AttachmentManager, SubmissionManager;

    public function index(ApplyNewSubmissionRequest $request)
    {
        try {
            $this->applyNewSubmission($request);

             return ApiResponder::success(
                 [],
                 "Successfully [apply new submission]",
                 Response::HTTP_CREATED
             );
        } catch (\Exception $exception) {
             return ApiResponder::error(
                 $exception->getMessage(),
                 Response::HTTP_BAD_REQUEST);
        }
    }
}
