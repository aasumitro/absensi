<div class="form-group mb-4">
    <label for="min_att_out">Jam pulang (mulai)</label>
    <div class="input-group">
        <span class="input-group-text" id="min_att_out_icon">
            <span class="fas fa-clock"></span>
        </span>
        <input
            id="min_att_out"
            type="text"
            class="form-control @error('min_att_out') is-invalid @enderror"
            placeholder="e.g. 16:00"
            wire:model="min_att_out"
            autofocus
            required
        >
        @error('min_att_out')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

