<div class="form-group mb-4">
    <label for="max_att_in">Jam masuk (batas)</label>
    <div class="input-group">
        <span class="input-group-text" id="max_att_in_icon">
            <span class="fas fa-clock"></span>
        </span>
        <input
            id="max_att_in"
            type="text"
            class="form-control @error('max_att_in') is-invalid @enderror"
            placeholder="e.g. 08:00"
            wire:model="max_att_in"
            autofocus
            required
        >
        @error('max_att_in')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

