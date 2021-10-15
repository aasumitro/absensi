<?php

namespace App\Models\Managers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

trait AttachmentManager
{
    private string $fetch_attachment_key = 'livewire_trait_attachment_list';

    public function fetchAttachment()
    {
        return Cache::remember($this->fetch_attachment_key, $this->cache_time, function ()
        {
            return Attachment::withCount(
                'mobilePreferences', 'attendances', 'submissions'
            )->get();
        });
    }

    public function newAttachment($data, $visibility = 'PUBLIC')
    {

        if ($data['type'] === 'IMAGE') {
            $folder_path = ($visibility === 'PUBLIC')
                ? 'public/uploads/images/mobile'
                : 'private/images';

            $file = $data['file']->store($folder_path);
            $file_name = explode('/', $file);
            $data['path'] = ($visibility === 'PUBLIC') ? 'images/mobile' : $folder_path;
            $data['name'] = end($file_name);
            unset($data['file']);
        }

        if ($data['type'] === 'FILE') {
            $folder_path = ($visibility === 'PUBLIC')
                ? 'public/uploads/files/mobile'
                : 'private/files';

            $file = $data['file']->store($folder_path);
            $file_name = explode('/', $file);
            $data['path'] = ($visibility === 'PUBLIC') ? 'files/mobile': $folder_path;
            $data['name'] = end($file_name);
            unset($data['file']);
        }

        $attachment = Attachment::create($data);

        Cache::forget($this->fetch_attachment_key);

        return $attachment;
    }

    public function modifyAttachment($id, $data, $status = "NO_CONTENT")
    {
        $attachment = Attachment::findOrFail($id);

        if ($data['type'] === 'IMAGE' && $status === "CONTENT") {
            Storage::disk('upload')->delete($attachment->name);
            $file = $data['file']->store('public/uploads/images/mobile');
            $file_name = explode('/', $file);
            $data['path'] = 'images/mobile';
            $data['name'] = end($file_name);
            Storage::deleteDirectory('livewire-tmp');
        }

        if ($data['type'] === 'LINK' && $attachment->type === "IMAGE") {
            Storage::disk('upload')->delete($attachment->name);
        }

        $attachment->name = $data['name'];
        $attachment->path = $data['path'];
        $attachment->type = $data['type'];
        $attachment->save();

        Cache::forget($this->fetch_attachment_key);
    }

    protected function destroyAttachment($attachment_id)
    {
        $attachment = Attachment::findOrFail($attachment_id);

        if ($attachment->type === 'IMAGE') {
            Storage::disk('upload')->delete($attachment->name);
        }

        $attachment->delete();

        Cache::forget($this->fetch_attachment_key);
    }
}
