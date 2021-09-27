<div class="form-group mb-4">
    <label for="zone">Silahkan pilih zona waktu</label>
    <div class="input-group">
        <span class="input-group-text" id="zone_icon">
            <span class="fas fa-clock"></span>
        </span>
        <select
            id="zone"
            class="form-control @error('zone') is-invalid @enderror"
            wire:model="zone"
            required
        >
            <option value="0">Pilih zona waktu</option>
            @foreach($timezones as $zone)
                <option
                    value="{{$zone->id}}"
                >
                    {{ucwords($zone->title)}} [{{$zone->locale}}]
                </option>
            @endforeach
        </select>
        <span class="input-group-text">
            <button
                wire:click="performUpdateTimezone"
                class="btn btn-outline-primary"
                type="button"
            >Save</button>
        </span>
        @error('role')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

