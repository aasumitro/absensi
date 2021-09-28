<?php

namespace App\Http\Livewire\Dash\Root;

use App\Models\Managers\AttachmentManager;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingAttachmentCreate extends Component
{
    use AttachmentManager, WithFileUploads;

    public $type;

    public $name;

    public $path;

    public $file;

    public function mount()
    {
        $this->type = "IMAGE";
    }

    public function render()
    {
        return view('livewire.dash.setting-attachment-create');
    }

    public function submit()
    {
        try {
            if ($this->type === 'IMAGE') {
                $data = $this->validate([
                    'type' => 'required',
                    'file' => 'image|max:1024', // 1MB Max
                ]);

                $this->newAttachment($data);
            }

            if ($this->type === 'LINK') {
                $data = $this->validate([
                    'type' => 'required',
                    'name' => 'required',
                    'path' => 'required'
                ]);

                $this->newAttachment($data);
            }

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[CREATE]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[CREATE]</b> failed" . $e->getMessage()
            ]);
        }

        $this->emit('attachmentListSectionRefresh');

        $this->dispatchBrowserEvent(
            'closeModal',
            ['action' => 'CREATE']
        );

        $this->reset();

        $this->type = "IMAGE";
    }
}
