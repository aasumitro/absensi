<div class="form-group mb-4">
    <label for="refresh_time">Refresh time digit</label>
    <div class="input-group">
        <span class="input-group-text" id="name_icon">
            <span class="fas fa-clock"></span>
        </span>
        <input
            id="refresh_time"
            type="number"
            class="form-control @error('refresh_time') is-invalid @enderror"
            placeholder="e.g. 1"
            wire:model="refresh_time"
            autofocus
            required
        >
        @error('refresh_time')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

