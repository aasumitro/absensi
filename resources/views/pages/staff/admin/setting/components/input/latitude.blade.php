<div class="form-group mb-4">
    <label for="latitude">Latitude</label>
    <div class="input-group">
        <span class="input-group-text" id="latitude_icon">
            <span class="fas fa-map-pin"></span>
        </span>
        <input
            id="latitude"
            type="text"
            class="form-control @error('latitude') is-invalid @enderror"
            placeholder="e.g. 1.23232"
            wire:model="latitude"
            autofocus
            required
        >
        @error('latitude')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

