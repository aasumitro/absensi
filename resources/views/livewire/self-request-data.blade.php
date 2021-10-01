<div>
    <div class="form-group mb-4">
        <label for="type">Silahkan Pilih tipe pengajuan</label>
        <div class="input-group">
            <span class="input-group-text" id="type_icon">
                <span class="fas fa-sticky-note"></span>
            </span>
            <select
                id="type"
                wire:model="type"
                class="form-control @error('type') is-invalid @enderror"
                required
            >
                <option value="NULL">Pilih tipe pengajuan</option>
                <option value="SUGGEST">Kritik & Saran</option>
                <option value="ADMIN_ACCOUNT">Akun admin baru</option>
            </select>

            @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    @if($type === 'SUGGEST')
    <section id="suggestions">
        <form wire:submit.prevent="performNewSuggestion">
            <div class="form-group mb-4">
                <label for="title">Judul</label>
                <div class="input-group">
                    <span class="input-group-text" id="title_icon">
                        <span class="fas fa-heading"></span>
                    </span>
                    <input
                        id="title"
                        type="text"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="e.g. Hello saya bosan"
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
            <div class="form-group mb-4">
                <label for="body">Jabarkan secara detail Kritik, Saran, Masukkan, atau Pengajuan Anda!</label>
                <div class="input-group">
                    <span class="input-group-text" id="body_icon">
                        <span class="fas fa-align-left"></span>
                    </span>
                    <textarea
                        wire:model="body"
                        class="form-control @error('body') is-invalid @enderror"
                        id="body"
                        rows="3"
                        autofocus
                        required
                    ></textarea>
                    @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <button class="btn btn-danger float-end">Kirim</button>
        </form>
    </section>
    @endif

    @if($type === 'ADMIN_ACCOUNT' && !auth()->user()->hasRole(MEMBER_ROLE_ID))
    <section id="admin-account">
        <form wire:submit.prevent="performRequestAdminAccount">
            <div class="form-group mb-4">
                <label for="status">Silahkan pilih status akun</label>
                <div class="input-group">
                    <span class="input-group-text" id="status_icon">
                        <i class="fas fa-user-slash"></i>
                    </span>
                    <select
                        id="status"
                        wire:model="status"
                        class="form-control @error('status') is-invalid @enderror"
                        required
                    >
                        <option value="NULL">Pilih satus akun</option>
                        <option value="NONE">Akun baru</option>
                        <option value="EXIST">Akun lama</option>
                    </select>

                    @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            @if($status === 'EXIST')
                @if (count($members) < 1)
                    <div>
                        Tidak ada akun ditemukan silahakan pilih buat akun baru.
                    </div>
                @else
                    <div class="form-group mb-4">
                        <label for="member_selected_id">Silahkan pilih akun</label>
                        <div class="input-group">
                        <span class="input-group-text" id="member_icon">
                            <i class="fas fa-users"></i>
                        </span>
                            <select
                                id="member_selected_id"
                                wire:model="member_selected_id"
                                class="form-control @error('member_selected_id') is-invalid @enderror"
                                required
                            >
                                <option value="NULL">Pilih akun</option>
                                @foreach($members as $member)
                                    <option value="{{$member['id']}}">
                                        {{$member['name']}}
                                    </option>
                                @endforeach
                            </select>

                            @error('member_selected_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                @endif
            @elseif($status === 'NONE')
                @include('components.input.name-input')
                @include('components.input.username-input', ['isReadOnly' => false])
                @include('components.input.email-input', ['isReadOnly' => false])
                @include('components.input.phone-input', ['isReadOnly' => false])
                @include('components.input.role-select')
            @endif
            <button class="btn btn-danger float-end">Kirim</button>
        </form>
    </section>
    @elseif($type === 'ADMIN_ACCOUNT' && auth()->user()->hasRole(MEMBER_ROLE_ID))
        <div>Anda tidak memiliki hak untuk melakukan aksi ini</div>
    @endif

    @include('components.message')
</div>

<script>
    let messageModal = document.getElementById('messageModal')
    let bsMessageModal = new bootstrap.Modal(messageModal)

    window.addEventListener('openModal', event => {
        if (event.detail.type === 'MESSAGE') {
            let title = event.detail.title
            let body = event.detail.body

            messageModal.addEventListener('show.bs.modal', function (modal) {
               messageModal.querySelector('.modal-title')
                   .textContent = title
               messageModal.querySelector('.modal-body')
                    .textContent = body
            })

            bsMessageModal.show()
        }
    })

    window.addEventListener('showNotify', event => {
        showNotification(
            event.detail.type,
            event.detail.message
        )
    })
</script>
