<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="editSliderPreferencesModal"
>
    <div
        class="modal-dialog modal-lg"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performUpdate">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Preference ({{$type}})</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="title">Title</label>
                        <div class="input-group">
                            <input
                                id="title"
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                wire:model="title"
                                autofocus
                                required
                            >
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 {{ ($type === 'ANNOUNCEMENT') ? 'col-md-12' : 'col-md-8'  }}">
                            <div class="form-group mb-4">
                                <label for="description">Description</label>
                                <div class="input-group">
                                    <textarea
                                        id="description"
                                        type="text"
                                        class="form-control @error('description') is-invalid @enderror"
                                        wire:model="description"
                                        autofocus
                                        required
                                        rows="5"
                                    ></textarea>
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if($type === 'SLIDER')
                            <div class="col-12 col-md-4">
                                <label for="attachment">Selected attachment</label>
                                <img
                                    src="{{asset("storage/uploads/{$this->attachment->path}/{$this->attachment->name}")}}"
                                    class="d-block w-100 mt-2" alt="{{$this->title}}"
                                >
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-4">
                                <label for="title">Date Show</label>
                                <div class="input-group">
                                    <input
                                        id="title"
                                        type="datetime-local"
                                        class="form-control @error('live_date_show') is-invalid @enderror"
                                        wire:model="live_date_show"
                                        autofocus
                                    >
                                    @error('live_date_show')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-4">
                                <label for="title">Date hide</label>
                                <div class="input-group">
                                    <input
                                        id="title"
                                        type="datetime-local"
                                        class="form-control @error('live_date_hide') is-invalid @enderror"
                                        wire:model="live_date_hide"
                                        autofocus
                                    >
                                    @error('live_date_hide')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-group mb-4">
                                <label for="type">Type</label>
                                <div class="input-group">
                                    <select
                                        id="type"
                                        class="form-control @error('type') is-invalid @enderror"
                                        wire:model="type"
                                        required
                                    >
                                        <option value="SLIDER">Slider</option>
                                        <option value="ANNOUNCEMENT">Annoucement</option>
                                    </select>

                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mb-4">
                                <label for="popup">Popup</label>
                                <div class="input-group">
                                    <select
                                        id="popup"
                                        class="form-control @error('popup') is-invalid @enderror"
                                        wire:model="popup"
                                        required
                                    >
                                        <option value="1">YES</option>
                                        <option value="0">NO</option>
                                    </select>

                                    @error('popup')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mb-4">
                                <label for="banner">Banner</label>
                                <div class="input-group">
                                    <select
                                        id="banner"
                                        class="form-control @error('banner') is-invalid @enderror"
                                        wire:model="banner"
                                        required
                                    >
                                        <option value="1">YES</option>
                                        <option value="0">NO</option>
                                    </select>

                                    @error('banner')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mb-4">
                                <label for="status">Status</label>
                                <div class="input-group">
                                    <select
                                        id="status"
                                        class="form-control @error('status') is-invalid @enderror"
                                        wire:model="status"
                                        required
                                    >
                                        <option value="SHOW">Show</option>
                                        <option value="HIDE">Hide</option>
                                    </select>

                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
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
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
