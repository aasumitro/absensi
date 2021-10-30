<div>
    <div class="row mt-4 mb-5">
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <i class="fas fa-building fa-3x"></i>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5"> SKPD</h2>
                                <h3 class="mb-1">{{$department_count}}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-black-400 mb-0"> SKPD</h2>
                                <h3 class="fw-extrabold mb-2">{{$department_count}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5"> Pegawai</h2>
                                <h3 class="mb-1">{{$member_count}}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-black-400 mb-0"> Pegawai</h2>
                                <h3 class="fw-extrabold mb-2">{{$member_count}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6.625 2.655A9 9 0 0119 11a1 1 0 11-2 0 7 7 0 00-9.625-6.492 1 1 0 11-.75-1.853zM4.662 4.959A1 1 0 014.75 6.37 6.97 6.97 0 003 11a1 1 0 11-2 0 8.97 8.97 0 012.25-5.953 1 1 0 011.412-.088z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M5 11a5 5 0 1110 0 1 1 0 11-2 0 3 3 0 10-6 0c0 1.677-.345 3.276-.968 4.729a1 1 0 11-1.838-.789A9.964 9.964 0 005 11zm8.921 2.012a1 1 0 01.831 1.145 19.86 19.86 0 01-.545 2.436 1 1 0 11-1.92-.558c.207-.713.371-1.445.49-2.192a1 1 0 011.144-.83z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M10 10a1 1 0 011 1c0 2.236-.46 4.368-1.29 6.304a1 1 0 01-1.838-.789A13.952 13.952 0 009 11a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5"> Aktifitas Presensi</h2>
                                <h3 class="mb-1">{{$attendance_count}}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-black-400 mb-0"> Aktifitas Presensi</h2>
                                <h3 class="fw-extrabold mb-2">{{$attendance_count}} </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-md-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                    <div class="d-block">
                        <div class="h6 fw-normal text-gray mb-2">Presentase presensi berdasarkan status (Senin - Jum'at)</div>
                        <h2 class="h3 fw-extrabold">
                            {{$now->startOfWeek(\Carbon\CarbonInterface::MONDAY)->format('d')}} -
                            {{$now->endOfWeek(\Carbon\CarbonInterface::FRIDAY)->format('d')}}
                            {{$now->format('F Y')}}
                        </h2>
                        <div class="d-flex">
                            <div class="small">
                                HADIR
                                (<span class="fw-bold">{{$pie_chart_status_attend}}</span>)
                            </div>
                            <span class="ms-2 me-2">|</span>
                            <div class="small">
                                TIDAK HADIR
                                (<span class="fw-bold">{{$pie_chart_status_absent}}</span>)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    @if($pie_chart_status_attend <= 0 && $pie_chart_status_absent <= 0)
                        <div class="text-center py-5">
                            Tidak ada data
                        </div>
                    @else
                        <div class="pie-chart-status py-5"></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                    <div class="d-block">
                        <div class="h6 fw-normal text-gray mb-2">Presentase presensi berdasarkan tipe (Senin - Jum'at)</div>
                        <h2 class="h3 fw-extrabold">
                            {{$now->startOfWeek(\Carbon\CarbonInterface::MONDAY)->format('d')}} -
                            {{$now->endOfWeek(\Carbon\CarbonInterface::FRIDAY)->format('d')}}
                            {{$now->format('F Y')}}
                        </h2>
                        <div class="d-flex">
                            <div class="small">
                                QR_SCAN
                                (<span class="fw-bold">{{$pie_chart_type_qrscan}}</span>)
                            </div>
                            <span class="ms-2 me-2">|</span>
                            <div class="small">
                                QR_GEN
                                (<span class="fw-bold">{{$pie_chart_type_qrgen}}</span>)
                            </div>
                            <span class="ms-2 me-2">|</span>
                            <div class="small">
                                PICTURE
                                (<span class="fw-bold">{{$pie_chart_type_picture}}</span>)
                            </div>
                            <span class="ms-2 me-2">|</span>
                            <div class="small">
                                SYSTEM
                                (<span class="fw-bold">{{$pie_chart_type_system}}</span>)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    @if($pie_chart_type_qrgen <= 0 && $pie_chart_type_qrscan <= 0 && $pie_chart_type_picture <= 0 && $pie_chart_type_system <= 0)
                        <div class="text-center py-5">
                            Tidak ada data
                        </div>
                    @else
                        <div class="pie-chart-type py-5"></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                    <div class="d-block">
                        <div class="h6 fw-normal text-gray mb-2">Presentase presensi tidak hadir (Senin - Jum'at)</div>
                        <h2 class="h3 fw-extrabold">
                            {{$now->startOfWeek(\Carbon\CarbonInterface::MONDAY)->format('d')}} -
                            {{$now->endOfWeek(\Carbon\CarbonInterface::FRIDAY)->format('d')}}
                            {{$now->format('F Y')}}
                        </h2>
                        <div class="d-flex">
                            <div class="small">
                                CUTI
                                (<span class="fw-bold">{{$pie_chart_absent_type_ct}}</span>)
                            </div>
                            <span class="ms-2 me-2">|</span>
                            <div class="small">
                                SAKIT
                                (<span class="fw-bold">{{$pie_chart_absent_type_sk}}</span>)
                            </div>
                            <span class="ms-2 me-2">|</span>
                            <div class="small">
                                TANPA KETERANGAN
                                (<span class="fw-bold">{{$pie_chart_absent_type_tk}}</span>)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    @if($pie_chart_absent_type_ct <= 0 && $pie_chart_absent_type_sk <= 0 && $pie_chart_absent_type_tk <= 0)
                        <div class="text-center py-5">
                            Tidak ada data
                        </div>
                    @else
                        <div class="pie-chart-absent-type py-5"></div>
                    @endif
                </div>
            </div>
        </div>


        <div class="col-12 col-md-8">
            <div class="card border-0 shadow">
                <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                    <div class="d-block">
                        <div class="h6 fw-normal text-gray mb-2">Total aktivitas mingguan (Senin - Jum'at)</div>
                        <h2 class="h3 fw-extrabold">
                            {{$now->startOfWeek(\Carbon\CarbonInterface::MONDAY)->format('d')}} -
                            {{$now->endOfWeek(\Carbon\CarbonInterface::FRIDAY)->format('d')}}
                            {{$now->format('F Y')}}
                        </h2>
                        <div class="d-flex">
                            <div class="small">
                                (IN)
                                <span class="fas fa-arrow-alt-circle-down text-success"></span>
                                <span class="text-success fw-bold">{{$in_count}}</span>
                            </div>
                            <span class="ms-2 me-2">|</span>
                            <div class="small">
                                (OUT)
                                <span class="fas fa-arrow-alt-circle-up text-danger"></span>
                                <span class="text-danger fw-bold">{{$out_count}}</span>
                            </div>
                            <span class="ms-2 me-2">|</span>
                            <div class="small">
                                (ABSENT)
                                <span class="far fa-file-alt text-warning"></span>
                                <span class="text-warning fw-bold">{{$absent_count}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    @if($absent_count <= 0 && $in_count <= 0 && $out_count <= 0)
                        <div class="text-center py-5">
                            Tidak ada data
                        </div>
                    @else
                        <div class="ct-chart-ranking ct-golden-section ct-series-a"></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                    <h2 class="fs-5 fw-bold mb-0">Aktifitas terakhir</h2>
                    <a href="#" class="btn btn-sm btn-primary">Selengkapnya</a>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush list my--3">
                        @if(count($latest_activities) > 0)
                            @foreach($latest_activities as $activity)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="#" class="avatar">
                                                <img
                                                    class="rounded"
                                                    alt="Image placeholder"
                                                    src="{{default_profile_picture($activity->data)}}"
                                                >
                                            </a>
                                        </div>
                                        <div class="col-auto ms--2">
                                            <h4 class="h6 mb-0">
                                                <a href="#">{{$activity->data}}</a>
                                            </h4>
                                            <div class="d-flex align-items-center">
                                                <small>
                                                    @if($activity->type === 'ABSENT')
                                                        {{\Carbon\Carbon::parse($activity->date)->format('d, M Y')}}
                                                        <br><code>[{{$activity->type_detail}}]</code>
                                                    @else
                                                        {{\Carbon\Carbon::parse($activity->datetime)->format('d, M Y H:i')}}
                                                        @if($activity->type === 'IN' && $activity->status === 'OVERTIME')
                                                            <br> <code>[TERLAMBAT]</code>
                                                        @endif
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col text-end">
                                            @if($activity->type === 'ABSENT')
                                                <a href="#" class="btn btn-sm btn-warning">
                                                    <i class="far fa-file-alt"></i>
                                                    <span>{{ucwords($activity->type)}}</span>
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-sm btn-{{$activity->type === 'IN' ? 'success' : 'danger'}}">
                                                    <i class="fas fa-arrow-alt-circle-{{$activity->type === 'IN' ? 'down' : 'up'}}"></i>
                                                    <span>{{ucwords($activity->type)}}</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item px-0 text-center">
                                Tidak ada data
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- Care about people's approval and you will be their prisoner. --}}
</div>

@section('custom-script')
    <script>
        if(d.querySelector('.ct-chart-ranking')) {
            let labels = @json($labels);
            let series = @json($series);

            let chart = new Chartist.Bar('.ct-chart-ranking', {
                labels: labels,
                series: series
            }, {
                low: 0,
                showArea: true,
                plugins: [
                    Chartist.plugins.tooltip()
                ],
                axisX: {
                    // On the x-axis start means top and end means bottom
                    position: 'end'
                },
                axisY: {
                    // On the y-axis start means left and end means right
                    showGrid: false,
                    showLabel: false,
                    offset: 0
                }
            });

            chart.on('draw', function(data) {
                if(data.type === 'line' || data.type === 'area') {
                    data.element.animate({
                        d: {
                            begin: 2000 * data.index,
                            dur: 2000,
                            from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                            to: data.path.clone().stringify(),
                            easing: Chartist.Svg.Easing.easeOutQuint
                        }
                    });
                }
            });
        }

        if(d.querySelector('.pie-chart-status')) {
            let data = {
                series: @json($pie_chart_status_series)
            };

            let sum = function(a, b) { return a + b };

            new Chartist.Pie('.pie-chart-status', data, {
                labelInterpolationFnc: function(value) {
                    return Math.round(value / data.series.reduce(sum) * 100) + '%';
                },
                plugins: [
                    Chartist.plugins.tooltip()
                ],
            });
        }

        if(d.querySelector('.pie-chart-type')) {
            let data = {
                series: @json($pie_chart_type_series)
            };

            let sum = function(a, b) { return a + b };

            new Chartist.Pie('.pie-chart-type', data, {
                labelInterpolationFnc: function(value) {
                    return Math.round(value / data.series.reduce(sum) * 100) + '%';
                },
                plugins: [
                    Chartist.plugins.tooltip()
                ],
            });
        }

        if(d.querySelector('.pie-chart-absent-type')) {
            let data = {
                series: @json($pie_chart_absent_type_series)
            };

            let sum = function(a, b) { return a + b };

            new Chartist.Pie('.pie-chart-absent-type', data, {
                labelInterpolationFnc: function(value) {
                    return Math.round(value / data.series.reduce(sum) * 100) + '%';
                },
                plugins: [
                    Chartist.plugins.tooltip()
                ],
            });
        }
    </script>
@endsection
