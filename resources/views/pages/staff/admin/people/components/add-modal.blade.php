<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="addManualDepartmentPeopleModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performAddNewMember">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah pegawai baru</h5>
                </div>
                <div class="modal-body">
                    @include('components.input.name-input')
                    @include('components.input.username-input', ['isReadOnly' => false])
                    @include('components.input.email-input', ['isReadOnly' => false])
                    @include('components.input.phone-input', ['isReadOnly' => false])
                    @include('components.input.role-select')
                    <p>
                        <span class="text-warning">Perhatian:</span>
                        untuk menambah akun dengan peran <code>Admin</code> silahkan
                        hubungi  pemegang akun dengan hak dan peran sebagai
                        <code>SuperAdmin</code> atau silahkan mengisi formulir pada link berikut
                        <a href="{{route('requests')}}" class="text-info text-underline" target="_blank">
                            formulir pengajuan akun admin
                        </a>
                    </p>
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
                        Tambah
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
