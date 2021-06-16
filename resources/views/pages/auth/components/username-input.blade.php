<div class="form-group mb-4">
    <label for="username">Your username</label>
    <div class="input-group">
        <span class="input-group-text" id="username">
            <span class="fas fa-user"></span>
        </span>
        <input
            id="username"
            type="text"
            class="form-control @error('username') is-invalid @enderror"
            placeholder="e.g. 82271111111 or absensi@oksetda.id"
            wire:model="username"
            autofocus
            required
        >
        @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    @if(!$errors->first('username'))
    <div id="usernameHelp" class="form-text">Use your phone number or email address.</div>
    @endif
</div>

