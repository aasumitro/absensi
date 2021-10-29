<div class="form-group mb-4">
    <label for="phone">Nomor ponsel Anda {{$isReadOnly ? "(readonly)" : ""}}</label>
    <div class="input-group">
        <span class="input-group-text" id="phone_icon">
            <span class="fas fa-phone"></span>
        </span>
        <input
            id="phone"
            type="number"
            class="form-control @error('phone') is-invalid @enderror"
            placeholder="e.g. 822XXXX (tanpa angka 0)"
            wire:model="phone"
            {{$isReadOnly ? "readonly" : ""}}
            autofocus
            required
            aria-describedby="phoneHelp"
        >
        @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div id="phoneHelp" class="form-text">
        Masukkan nomor ponsel tanpa angka 0.
    </div>
</div>

