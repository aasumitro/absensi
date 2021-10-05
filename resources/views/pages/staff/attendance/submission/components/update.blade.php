<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="editSubmission"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performUpdateSubmission">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbaharui pengajuan (Terima/Tolak)</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="update_status">Silahkan pilih status</label>
                        <div class="input-group">
                            <span class="input-group-text" id="update_status_icon">
                                <span class="fas fa-tags"></span>
                            </span>
                            <select
                                id="update_status"
                                class="form-control @error('update_status') is-invalid @enderror"
                                wire:model="update_status"
                                required
                            >
                                <option value="ACCEPTED">TERIMA</option>
                                <option value="REJECTED">TOLAK</option>
                            </select>

                            @error('update_status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    @if($update_status === 'REJECTED')
                        <div class="form-group mb-4">
                            <label for="update_notes">Berikan penjelasan</label>
                            <div class="input-group">
                                <span class="input-group-text" id="update_notes_icon">
                                    <span class="fas fa-sticky-note"></span>
                                </span>
                                <textarea
                                    wire:model="update_notes"
                                    class="form-control @error('update_notes') is-invalid @enderror"
                                    id="update_notes"
                                    rows="3"
                                    autofocus
                                    required
                                ></textarea>
                                @error('update_notes')
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
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Perbaharui
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
