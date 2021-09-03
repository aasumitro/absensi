<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="addAttachmentModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="submit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new Attachment</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="type">Type</label>
                        <div class="input-group">
                            <select
                                id="type"
                                class="form-control @error('type') is-invalid @enderror"
                                wire:model="type"
                                required
                            >
                                <option value="IMAGE">IMAGE</option>
                                <option value="LINK">LINK</option>
                            </select>

                            @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    @if($type === 'IMAGE')
                        <div class="row">
                            <div class="col-6">
                                <label for="file_preview" class="form-label">Preview</label>
                                @if($file)
                                    <img
                                        src="{{$file->temporaryUrl()}}"
                                        class="d-block w-100" alt="{{$file->temporaryUrl()}}"
                                    >
                                @else
                                    <br> <span>NO IMAGE SELECTED</span>
                                @endif
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="file" class="form-label">Select image</label>
                                    <input
                                        wire:model="file"
                                        class="form-control  @error('file') is-invalid @enderror"
                                        type="file"
                                        id="file"
                                    >
                                    @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($type === 'LINK')
                        <div class="form-group mb-4">
                            <label for="name">Name</label>
                            <div class="input-group">
                                <input
                                    id="name"
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    wire:model="name"
                                    autofocus
                                    required
                                >
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="path">Path</label>
                            <div class="input-group">
                                <input
                                    id="path"
                                    type="text"
                                    class="form-control @error('path') is-invalid @enderror"
                                    wire:model="path"
                                    autofocus
                                    required
                                >
                                @error('path')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-dark"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
