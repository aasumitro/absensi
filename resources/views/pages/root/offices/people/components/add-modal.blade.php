<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="departmentAddMemberModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
    >
        <form wire:submit.prevent="performAddMember">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah pegawai baru</h5>
                </div>
                <div class="modal-body">
                    @include('components.input.username-input', ['isReadOnly' => false])
                    @include('components.input.email-input', ['isReadOnly' => false])
                    @include('components.input.phone-input', ['isReadOnly' => false])
                    @include('components.input.name-input')
                    @include('components.input.department-select')
                    <h5>Mohon diperhatikan!</h5>
                    <p>
                        1. Peran untuk pegawai secara otomatis adalah member,
                        jika Anda ingin membuat akun admin silahkan melalui menu
                        <a href="{{route('users.accounts')}}" class="text-underline text-info">Pengguna/Akun</a>
                    </p>
                    <p>
                        2. Jika Anda telah terlanjur membuat akun, dan ingin memberikan
                        akses admin silahkan lakukan perubahan menggunakan fitur
                        <a href="{{route('requests')}}" class="text-underline text-info" target="_blank">Pengajuan</a>,
                        dengan tipe <code>`Akun admin baru`</code> dan status <code>`Akun lama`</code>.
                        Setelah itu silahkan lakukan konfirmasi pada menu
                        <a href="{{route('users.submissions')}}" class="text-underline text-info">Pengguna/Pengajuan</a>.
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
                        Buat
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
