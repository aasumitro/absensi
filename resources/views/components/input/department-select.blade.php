<div class="form-group mb-4">
    <label for="department">Silahkan pilih SKPD</label>
    <div class="input-group">
        <span class="input-group-text" id="department_icon">
            <span class="fas fa-building"></span>
        </span>
        <select
            id="department"
            class="form-control @error('department') is-invalid @enderror"
            wire:model="department"
            required
        >
            <option value="0">Pilih SKPD</option>
            @foreach($departments as $department)
                <option value="{{$department->id}}">{{ucwords($department->name)}}</option>
            @endforeach
        </select>

        @error('department')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

