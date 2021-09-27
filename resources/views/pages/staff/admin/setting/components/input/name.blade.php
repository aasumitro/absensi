<div class="form-group mb-4">
    <label for="name">Nama SKPD</label>
    <div class="input-group">
        <span class="input-group-text" id="name_icon">
            <span class="fas fa-building"></span>
        </span>
        <input
            id="name"
            type="text"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="e.g. Biro Umum"
            wire:model="name"
            autofocus
            required
        >
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

