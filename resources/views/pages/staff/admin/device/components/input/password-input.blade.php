<div class="form-group mb-4">
    <label for="password">Kata sandi</label>
    <div class="input-group">
        <span class="input-group-text" id="name_icon">
            <span class="fas fa-lock"></span>
        </span>
        <input
            id="password"
            type="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="e.g. * * * * *"
            wire:model="password"
            autofocus
            required
        >
        <span class="input-group-text p-0">
            <button
                onclick="obscureSecretText()"
                class="btn btn-icon-only"
                type="button"
            ><i id="password_obscure_icon" class="fas fa-eye"></i></button>
        </span>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

