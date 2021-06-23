<div class="card card-body shadow-sm">
    <div class="mb-3 mb-lg-0">
        <h1 class="h4">Slider Viewer</h1>
        <p>Slider viewer example that will display on mobile app!</p>
    </div>

    @if($preferences->count() <= 0)
        <div class="mt-4 text-center">
            No data available
        </div>
    @else
        <div id="carouselSliderControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($preferences as $preference)
                    @if($preference->type === 'SLIDER' && $preference->status === 'SHOW')
                        <div class="carousel-item {{ $loop->iteration === 1 ? 'active' : ''}}">
                            <img
                                src="{{asset("storage/uploads/{$preference->attachment->path}/{$preference->attachment->name}")}}"
                                class="d-block w-100" alt="{{$preference->title}}"
                            >
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{$preference->title}}</h5>
                                <p>{{$preference->description}}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselSliderControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselSliderControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @endif
</div>
