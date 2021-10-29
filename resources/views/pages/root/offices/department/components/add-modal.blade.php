<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="departmentAddModal"
>
    <div
        class="modal-dialog modal-lg"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performCreate">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah data SKPD baru</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="name">Nama SKPD</label>
                        <div class="input-group">
                            <span class="input-group-text" id="name_icon">
                                <span class="fas fa-building"></span>
                            </span>
                            <input
                                id="name"
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="e.g. Biro Perawatan"
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
                        <label for="timezone">Zona waktu</label>
                        <div class="input-group">
                            <span class="input-group-text" id="timezone_icon">
                                <span class="fas fa-clock"></span>
                            </span>
                            <select
                                id="timezone"
                                class="form-control @error('timezone') is-invalid @enderror"
                                wire:model="timezone"
                                required
                            >
                                <option value="0">Pilih zona waktu</option>
                                @foreach($timezones as $timezone)
                                    <option value="{{$timezone->id}}">{{ucwords($timezone->title)}} [{{ucwords($timezone->locale)}}]</option>
                                @endforeach
                            </select>

                            @error('timezone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            @include('pages.staff.admin.setting.components.input.max_att_in')
                        </div>
                        <div class="col-12 col-md-6">
                            @include('pages.staff.admin.setting.components.input.min_att_out')
                        </div>
                        <span>
                            Gunakan format
                            [<span class="text-warning">MENIT:DETIK</span>]
                            dengan format 24 jam contohnya [<span class="text-success">18:20</span>]
                        </span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="min_att_acc">Toleransi Minimum</label>
                                <div class="input-group">
                                <span class="input-group-text" id="max_att_in_icon">
                                    <span class="fas fa-clock"></span>
                                </span>
                                    <input
                                        id="min_att_acc"
                                        type="text"
                                        class="form-control"
                                        placeholder="e.g. 180"
                                        wire:model="min_att_acc"
                                        aria-describedby="minAttAccHelp"
                                        readonly
                                    >
                                    <div id="minAttAccHelp" class="form-text">
                                        Toleransi batas <code>minumum</code> absensi masuk secara default adalah <code>180 menit</code>
                                        atau <code>3 jam</code> jadi, ketika jam masuk adalah pukul <code>08:00 pagi</code> maka
                                        pengguna dapat melakukan absensi masuk mulai dari pukul <code>05:00 pagi</code>.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="max_att_acc">Toleransi Maksimum</label>
                                <div class="input-group">
                                <span class="input-group-text" id="max_att_in_icon">
                                    <span class="fas fa-clock"></span>
                                </span>
                                    <input
                                        id="max_att_acc"
                                        type="text"
                                        class="form-control"
                                        placeholder="e.g. 180"
                                        wire:model="max_att_acc"
                                        readonly
                                        aria-describedby="maxAttAccHelp"
                                    >
                                    <div id="maxAttAccHelp" class="form-text">
                                        Toleransi batas <code>maksimum</code> absensi masuk secara default adalah <code>60 menit</code>
                                        atau <code>1 jam</code> jadi, ketika jam masuk adalah pukul <code>08:00 pagi</code> maka batas maksimum
                                        melakukan absensi adalah pukul <code>09:00 pagi</code>.
                                    </div>
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
