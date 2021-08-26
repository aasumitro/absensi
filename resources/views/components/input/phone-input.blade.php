<div class="form-group mb-4">
    <label for="phone">Your phone number</label>
    <div class="input-group">
        <span class="input-group-text" id="phone_icon">
            <span class="fas fa-phone"></span>
        </span>
        <input
            id="phone"
            type="text"
            class="form-control @error('phone') is-invalid @enderror"
            placeholder="e.g. 822XXXX (Without 0)"
            wire:model="phone"
            autofocus
            required
        >
        @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

