<div class="row">
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                            <i class="far fa-file-alt fa-2x"></i>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5"> TOTAL PENGAJUAN</h2>
                            <h3 class="mb-1">0</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-black-400 mb-0"> TOTAL PENGAJUAN</h2>
                            <h3 class="fw-extrabold mb-2">{{$submission_total}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                            <i class="far fa-calendar-minus fa-2x"></i>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5"> MENUNGGU</h2>
                            <h3 class="mb-1">0</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-black-400 mb-0"> MENUNGGU</h2>
                            <h3 class="fw-extrabold mb-2">{{$submission_process_total}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                            <i class="far fa-calendar-check fa-2x"></i>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5"> DITERIMA</h2>
                            <h3 class="mb-1">0</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-black-400 mb-0"> DITERIMA</h2>
                            <h3 class="fw-extrabold mb-2">{{$submission_accepted_total}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                            <i class="far fa-calendar-times fa-2x"></i>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5"> DITOLAK</h2>
                            <h3 class="mb-1">0</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-black-400 mb-0"> DITOLAK</h2>
                            <h3 class="fw-extrabold mb-2">{{$submission_rejected_total}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
