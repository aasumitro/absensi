<div>
    <div class="row">
        <div class="col-12 col-md-6 my-2 d-flex align-items-stretch">
            @include('pages.root.settings.mobile.components.slider-viewer')
        </div>
        <div class="col-12 col-md-6 my-2 d-flex align-items-stretch">
            @include('pages.root.settings.mobile.components.slider-table')
        </div>
        <div class="col-12 col-md-6 my-2 d-flex align-items-stretch">
            @include('pages.root.settings.mobile.components.announcement')
        </div>
        <div class="col-12 col-md-6 my-2 d-flex align-items-stretch">
            @livewire('dash.root.setting-mobile-remote-config')
        </div>
        <div class="col-12 mb-5">
            @livewire('dash.root.setting-attachment')
        </div>
    </div>

    @include('pages.root.settings.mobile.components.update-slider')
    @livewire('dash.root.setting-attachment-create')
</div>
