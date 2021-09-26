<div class="form-group mb-4">
    <label for="unique_id">UUID Anda {{$isReadOnly ? "(readonly)" : ""}}</label>
    <div class="input-group">
        <span class="input-group-text" id="unique_id_icon">
            <span class="fas fa-fingerprint"></span>
        </span>
        <input
            id="unique_id"
            type="text"
            class="form-control @error('unique_id') is-invalid @enderror"
            wire:model="unique_id"
            {{$isReadOnly ? "readonly" : ""}}
            autofocus
            required
        >
        @error('unique_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

