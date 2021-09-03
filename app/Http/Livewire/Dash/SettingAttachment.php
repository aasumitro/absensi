<?php

namespace App\Http\Livewire\Dash;

use App\Models\Attachment;
use App\Models\Managers\AttachmentManager;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingAttachment extends Component
{
    use AttachmentManager, WithFileUploads;

    protected int $cache_time = 120;

    public $selected_id;

    public $name;

    public $path;

    public $type;

    public $file;

    protected $listeners = ['attachmentListSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.setting-attachment', [
            'attachments' => $this->fetchAttachment()
        ]);
    }

    public function selectedAttachment(Attachment $attachment, $action)
    {
        $this->selected_id = $attachment->id;

        if ($action === 'UPDATE') {
            $this->type = $attachment->type;
            $this->path = $attachment->path;
            $this->name = $attachment->name;
        }

        $this->dispatchBrowserEvent(
            'openModal',
            ['action' => $action, 'type' => 'ATTACHMENT']
        );
    }

    public function performDestroy(int $attachment_id): void
    {
        try {
            $this->destroyAttachment($attachment_id);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[DESTROY]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[DESTROY]</b> failed"
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'DESTROY']
        );

        $this->emit('attachmentListSectionRefresh');
    }

    public function performUpdateAttachment()
    {
        try {
            if ($this->type === 'IMAGE') {
                if ($this->file) {
                    $data = $this->validate([
                        'type' => 'required',
                        'file' => 'image|max:1024', // 1MB Max
                    ]);

                     $this->modifyAttachment($this->selected_id, $data, 'CONTENT');
                } else {
                    $data = $this->validate([
                        'type' => 'required',
                        'name' => 'required',
                        'path' => 'required'
                    ]);

                     $this->modifyAttachment($this->selected_id, $data);
                }
            }

            if ($this->type === 'LINK') {
                $data = $this->validate([
                    'type' => 'required',
                    'name' => 'required',
                    'path' => 'required'
                ]);

                $this->modifyAttachment($this->selected_id,  $data);
            }

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed"
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['action' => 'UPDATE', 'type' => 'ATTACHMENT']
        );

        $this->reset();

        $this->emit('attachmentListSectionRefresh');
    }
}
