<div class="card card-body shadow-sm table-wrapper table-responsive">
    <div class="mb-3 mb-lg-0">
        <div class="row">
            <div class="col-12 col-md-8">
                <h1 class="h4">Attachment List</h1>
                <p>Slider list with action todo!</p>
            </div>
            <div class="col-12 col-md-4">
                <a
                    data-bs-toggle="modal"
                    data-bs-target="#addAttachmentModal"
                    class="btn btn-primary float-end"
                >Add new Attachment</a>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Preview</th>
            <th>Path/Name</th>
            <th>Type</th>
            <th>Usage</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($attachments as $attachment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="width: 150px" class="text-center">
                    @if($attachment->type === 'LINK')
                        NONE
                    @else
                        <img
                            src="{{asset("storage/uploads/{$attachment->path}/{$attachment->name}")}}"
                            class="d-block w-100" alt="{{$attachment->name}}"
                        >
                    @endif
                </td>
                <td>
                    @if($attachment->type === 'LINK')
                        <b>{{$attachment->name}}</b> <br>
                        {{$attachment->path}}
                    @else
                        {{$attachment->path}}/{{$attachment->name}}
                    @endif

                </td>
                <td>{{$attachment->type}}</td>
                <td>
                    total usage ({{
                        $attachment->mobile_preferences_count +
                        $attachment->submissions_count +
                        $attachment->attendances_count
                    }})
                    <br>attendance ({{$attachment->attendances_count}})
                    <br>submission ({{$attachment->submissions_count}})
                    <br>slider ({{$attachment->mobile_preferences_count}})
                </td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="icon icon-sm">
                                <span class="fas fa-ellipsis-h icon-dark"></span>
                            </span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" data-popper-placement="bottom-end">
                            <a
                                wire:click="selectedAttachment({{$attachment}}, 'UPDATE')"
                                class="dropdown-item">
                                <span class="fas fa-edit me-2"></span>
                                Edit
                            </a>
                            <a
                                wire:click="selectedAttachment({{$attachment}}, 'DESTROY')"
                                class="dropdown-item text-danger rounded-bottom">
                                <span class="fas fa-trash-alt me-2"></span>
                                Remove
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if($attachments->count() <= 0)
        <div class="mt-4 text-center">
            No data available
        </div>
    @endif

    @include('components.delete-modal')
</div>
