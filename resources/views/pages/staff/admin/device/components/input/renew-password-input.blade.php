<div class="form-group mb-4">
    <label for="renew_password">Masukkan kembali Kata sandi diatas</label>
    <div class="input-group">
        <span class="input-group-text" id="name_icon">
            <span class="fas fa-lock"></span>
        </span>
        <input
            id="renew_password"
            type="password"
            class="form-control @error('renew_password') is-invalid @enderror"
            placeholder="e.g. * * * * *"
            wire:model="renew_password"
            autofocus
            required
        >
        @error('renew_password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

