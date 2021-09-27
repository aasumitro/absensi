<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="editDepartmentDeviceModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performUpdateDevice">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbaharui data umum perangkat</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" wire:model="selected_id">
                    @include('pages.staff.admin.device.components.input.name-input')
                    <div class="row">
                        <div class="col-6">
                            @include('pages.staff.admin.device.components.input.time-mode-select')
                        </div>
                        <div class="col-6">
                            @include('pages.staff.admin.device.components.input.time-number-input')
                        </div>
                        <span>
                            <span class="text-warning">REFRESH_TIME_DIGIT</span> minimal bernilai 1 untuk mode
                            <span class="text-warning">MENIT</span> dan minimal 30 jika bermode
                            <span class="text-warning">DETIK</span>, apabila kurang dari nilai tersebut
                            secara default sistem akan menetapkan berdasarkan nilai minumum!
                        </span>
                    </div>
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
