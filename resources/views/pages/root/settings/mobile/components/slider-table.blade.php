<div class="card card-body shadow-sm table-wrapper table-responsive">
    <div class="mb-3 mb-lg-0">
        <h1 class="h4">Daftar Slider</h1>
        <p>Daftar slider yang ditambahkan!</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $iteration = 1 @endphp
            @foreach($preferences as $preference)
                @if($preference->type === 'SLIDER')
                    <tr>
                        <td>{{ $iteration }}</td>
                        <td>
                            {{$preference->title}}
                            <span class="badge bg-primary py-1 px-2">
                                {{$preference->status}}
                            </span> <br>
                            @if($preference->live_date_show && $preference->live_date_hide)
                                <code>
                                    Ditampilkan
                                    ({{\Carbon\Carbon::parse($preference->live_date_show)->format('d') }}
                                    - {{\Carbon\Carbon::parse($preference->live_date_hide)->format('d') }})
                                    {{\Carbon\Carbon::parse($preference->live_date_show)->format('M Y') }}<br>
                                </code>
                            @elseif ($preference->status === 'SHOW')
                                <code>Ditampilkan setiap hari</code>
                            @endif
                        </td>
                        <td>
                            <a
                                wire:click="selectedPreferences({{$preference}}, 'SLIDER','UPDATE')"
                                class="btn btn-icon-only bg-primary ms-3">
                                <i class="fas fa-edit text-white"></i>
                            </a>
                        </td>
                    </tr>
                    @php $iteration++ @endphp
                @endif
            @endforeach
        </tbody>
    </table>

    @if($preferences->count() <= 0)
        <div class="mt-4 text-center">
            Data tidak tersedia
        </div>
    @endif
</div>
