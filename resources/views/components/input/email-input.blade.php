<div class="form-group mb-4">
    <label for="email">Your email address</label>
    <div class="input-group">
        <span class="input-group-text" id="email_icon">
            <span class="fas fa-envelope"></span>
        </span>
        <input
            id="email"
            type="text"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="e.g. info@sulutprov.go.id"
            wire:model="email"
            autofocus
            required
        >
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

