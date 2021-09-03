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

    public function newAttachment($data)
    {
        if ($data['type'] === 'IMAGE') {
            $file = $data['file']->store('public/uploads/images/mobile');
            $file_name = explode('/', $file);
            $data['path'] = 'images/mobile';
            $data['name'] = end($file_name);
            Storage::deleteDirectory('livewire-tmp');
        }

        Attachment::create($data);

        Cache::forget($this->fetch_attachment_key);
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
