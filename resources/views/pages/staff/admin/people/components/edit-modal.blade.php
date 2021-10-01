<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="editMemberAccountModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performUpdate">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbaharui data pegawai</h5>
                </div>
                <div class="modal-body">
                    @include('components.input.username-input', ['isReadOnly' => true])
                    @include('components.input.email-input', ['isReadOnly' => true])
                    @include('components.input.phone-input', ['isReadOnly' => true])
                    @include('components.input.name-input')
                    @include('components.input.role-select')
                    @if($current_user_role_id === ADMIN_ROLE_ID)
                    <p>
                        <span class="text-warning">Perhatian:</span>
                        Jika akun anda adalah <code>admin</code>
                        dan tidak memilih maka akun akan tetap
                        menjadi <code>admin</code>, jika anda memilih
                        salah satu maka Hak dan Peran akan dirubah sesuai
                        apa yang dipilih!
                    </p>
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
