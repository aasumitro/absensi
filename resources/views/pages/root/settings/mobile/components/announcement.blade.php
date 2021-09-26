<div class="card card-body shadow-sm">
    <div class="mb-3 mb-lg-0">
        <h1 class="h4">Pengumuman</h1>
        <p>Pengumuman aktif yang akan di tampilakan pada aplikasi seluler!</p>
    </div>

    <div class="row">
        @if($preferences->count() <= 0)
            <div class="mt-4 text-center">
                Data tidak ditemukan
            </div>
        @else
            @foreach($preferences as $preference)
                @if($preference->type === 'ANNOUNCEMENT')
                    <div class="card border-warning col-12 p-5">
                        <div class="card-body">
                            <h1>
                                {{$preference->title}}
                            </h1>
                            <p>{{$preference->description}}</p>
                            <div class="row">
                                <div class="col-8">
                                    <div class="d-flex">
                                        @if($preference->popup)
                                            <span class="badge bg-primary py-2 px-3 m-1">
                                               {{strtoupper("show as popup")}}
                                            </span>
                                        @endif
                                        @if($preference->banner)
                                            <span class="badge bg-primary py-2 px-3 m-1">
                                               {{strtoupper("show as banner")}}
                                           </span>
                                        @endif
                                        <span class="badge bg-{{($preference->status === 'SHOW') ? 'success' : 'warning'}} py-2 px-3 m-1">
                                               {{$preference->status}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <a
                                        wire:click="selectedPreferences({{$preference}}, 'ANNOUNCEMENT','UPDATE')"
                                        class="btn btn-icon-only bg-primary float-end">
                                        <i class="fas fa-edit text-white"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
