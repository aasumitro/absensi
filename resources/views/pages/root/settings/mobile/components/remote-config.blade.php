<div class="card card-body shadow-sm">
    <div class="mb-3 mb-lg-0">
        <h1 class="h4">Remote Config</h1>
        <p>Change the behavior and appearance of your app without publishing an app update, at no cost!</p>
    </div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Key</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>
            @foreach($settings as $setting)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        {{ucwords(str_replace('_', ' ' , $setting->key))}}
                        <br> Last update : {{$setting->updated_at->diffForHumans()}}
                    </td>
                    <td>
                        <label for="{{$setting->key}}" class="d-none"></label>
                        <input
                            id="{{$setting->key}}"
                            wire:model="{{$setting->key}}"
                            type="text"
                            class="form-control"
                        >
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button
            wire:click="performUpdate"
            class="btn btn-primary mt-3"
        >Save</button>
    </div>
</div>
