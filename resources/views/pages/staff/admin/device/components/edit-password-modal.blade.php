<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="updateDevicePasswordModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performUpdatePassword">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbaharui kata sandi perangkat</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" wire:model="selected_id">
                    @include('pages.staff.admin.device.components.input.new-password-input')
                    @include('pages.staff.admin.device.components.input.renew-password-input')
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
