<div class="form-group mb-4">
    <label for="role">Silahkan pilih peran</label>
    <div class="input-group">
        <span class="input-group-text" id="role_icon">
            <span class="fas fa-user-tag"></span>
        </span>
        <select
            id="role"
            class="form-control @error('role') is-invalid @enderror"
            wire:model="role"
            required
        >
            <option value="0">Pilih peran</option>
            @foreach($roles as $role)
                <option value="{{$role->id}}">{{ucfirst($role->title)}}</option>
            @endforeach
        </select>

        @error('role')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

