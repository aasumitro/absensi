<div class="col-12 col-md-6  mb-3 mb-xl-0 d-flex align-items-stretch">
    <div class="card card-body shadow-sm">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Zona waktu</h1>
            <p>Pengaturan zona waktu!</p>
        </div>
        <div class="mb-3 mr-3 ml-3">
            <b>Waktu saat ini (dipilih)</b>
            <div class="card border-warning p-3 mt-2">
                 <span class="fw-bold text-italic">
                    {{$department->timezone->title}}
                    [{{$department->timezone->locale}}] -
                    <span id="currentDatetime">loading . . .</span>
                </span>
            </div>
        </div>
        @include('pages.staff.admin.setting.components.input.zone-select')
    </div>
</div>
