<div class="form-group mb-4">
    <label for="longitude">Longitude</label>
    <div class="input-group">
        <span class="input-group-text" id="longitude_icon">
            <span class="fas fa-map-pin"></span>
        </span>
        <input
            id="longitude"
            type="text"
            class="form-control @error('longitude') is-invalid @enderror"
            placeholder="e.g. 142.2222"
            wire:model="longitude"
            autofocus
            required
        >
        @error('longitude')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

