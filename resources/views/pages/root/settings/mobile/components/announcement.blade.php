<div class="card card-body shadow-sm">
    <div class="mb-3 mb-lg-0">
        <h1 class="h4">Announcement</h1>
        <p>Announcement active that will be displayed on mobile app!</p>
    </div>

    <div class="row">
        @if($preferences->count() <= 0)
            <div class="mt-4 text-center">
                No data available
            </div>
        @else
            @foreach($preferences as $preference)
                @if($preference->type === 'ANNOUNCEMENT' && $preference->status === 'SHOW')
                    <div class="col-12 col-md-4">
                        <img
                            src="{{asset("storage/uploads/{$preference->attachment->path}/{$preference->attachment->name}")}}"
                            class="d-block w-100" alt="{{$preference->title}}"
                        >
                    </div>
                    <div class="col-12 col-md-8">
                        <h1>
                            <div class="d-flex">
                                {{$preference->title}}
                                <a class="btn btn-icon-only bg-primary ms-3">
                                    <i class="fas fa-edit text-white"></i>
                                </a>
                            </div>
                        </h1>
                        <p>{{$preference->description}}</p>
                        <div class="d-flex">
                            @if($preference->popup)
                                <span class="badge bg-primary py-2 px-3 m-1">
                                   {{strtoupper("show as popup")}}
                                </span>
                            @endif
                            @if($preference->popup)
                               <span class="badge bg-primary py-2 px-3 m-1">
                                   {{strtoupper("show as banner")}}
                               </span>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
