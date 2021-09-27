<div class="form-group mb-4">
    <label for="refresh_time_mode">Refresh time mode</label>
    <div class="input-group">
        <span class="input-group-text" id="role_icon">
            <span class="fas fa-clock"></span>
        </span>
        <select
            id="refresh_time_mode"
            class="form-control @error('refresh_time_mode') is-invalid @enderror"
            wire:model="refresh_time_mode"
            required
        >
            <option value="MINUTES">MENIT</option>
            <option value="SECONDS">DETIK</option>
        </select>
        @error('refresh_time_mode')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
