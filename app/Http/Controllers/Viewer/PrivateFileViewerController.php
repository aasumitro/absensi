<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Attachment;

class PrivateFileViewerController extends Controller
{
    public function __construct()
    {
        // TODO API MIDDLEWARE
        $this->middleware('auth');
    }

    public function view($id): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $attachment = Attachment::findOrFail($id);

        $file = storage_path("app/$attachment->path/") . $attachment->name;

        if (!file_exists($file)) {
            abort(404);
        }

        return response()->download(
            $file,
            "private_file_$attachment->name", [],
            'inline'
        );
    }
}
