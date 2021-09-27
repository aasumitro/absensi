<div class="col-12 col-md-6  mb-3 mb-xl-0 d-flex align-items-stretch">
    <div class="card card-body shadow-sm">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">SKPD</h1>
            <p>Pengaturan data SKPD!</p>
        </div>

        @include('pages.staff.admin.setting.components.input.name')
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                @include('pages.staff.admin.setting.components.input.latitude')
            </div>
            <div class="col-12 col-md-6">
                @include('pages.staff.admin.setting.components.input.longitude')
            </div>
            <span>
                Dapatkan titik koordinat dari
                <a
                    class="text-info text-italic text-underline"
                    href="https://www.google.com/maps/place/Kantor+Gubernur+Sulawesi+Utara/@1.4698653,124.8426492,17z/data=!3m1!4b1!4m5!3m4!1s0x328774defaaa0b67:0x8c760abcc417c2f1!8m2!3d1.4698599!4d124.8448432"
                    target="_blank"
                >Google Maps</a>
            </span>
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
        <button
            wire:click="performUpdateDepartment"
            class="btn btn-primary mt-1"
        >Simpan</button>
    </div>
</div>
