<div class="form-group mb-4">
    <label for="new_password">Kata sandi baru</label>
    <div class="input-group">
        <span class="input-group-text" id="name_icon">
            <span class="fas fa-lock"></span>
        </span>
        <input
            id="new_password"
            type="password"
            class="form-control @error('new_password') is-invalid @enderror"
            placeholder="e.g. * * * * *"
            wire:model="new_password"
            autofocus
            required
        >
        @error('new_password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

