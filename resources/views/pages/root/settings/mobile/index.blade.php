@extends('layouts.main')

@section('title', "Mobile Settings")

@section('content')
    <section class="mb-3">
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Mobile Apps</h1>
                <p class="mb-0">
                    Settings and References like sliders, announcement and others!
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 my-2 d-flex align-items-stretch">
                @include('pages.root.settings.mobile.components.slider-viewer')
            </div>
            <div class="col-12 col-md-6 my-2 d-flex align-items-stretch">
                @include('pages.root.settings.mobile.components.slider-table')
            </div>
            <div class="col-12 my-2">
                @include('pages.root.settings.mobile.components.announcement')
            </div>
        </div>
    </section>
@endsection

