<div class="card card-body shadow-sm table-wrapper table-responsive">
    <div class="mb-3 mb-lg-0">
        <h1 class="h4">Slider List</h1>
        <p>Slider list with action todo!</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $iteration = 1 @endphp
            @foreach($preferences as $preference)
                @if($preference->type === 'SLIDER')
                    <tr>
                        <td>{{ $iteration }}</td>
                        <td>
                            {{$preference->title}} <br>
                            {{$preference->description}} <br>
                            @if($preference->live_date_show && $preference->live_date_hide)
                                <code>
                                    displayed
                                    ({{\Carbon\Carbon::parse($preference->live_date_show)->format('d') }}
                                    - {{\Carbon\Carbon::parse($preference->live_date_hide)->format('d') }})
                                    {{\Carbon\Carbon::parse($preference->live_date_show)->format('M Y') }}<br>
                                </code>
                            @endif
                            <span class="badge bg-primary py-1 px-2">
                                {{$preference->status}}
                            </span>
                        </td>
                        <td>
                            <a class="btn btn-icon-only bg-primary ms-3">
                                <i class="fas fa-edit text-white"></i>
                            </a>
                        </td>
                    </tr>
                    @php $iteration++ @endphp
                @endif
            @endforeach
        </tbody>
    </table>

    @if($preferences->count() <= 0)
        <div class="mt-4 text-center">
            No data available
        </div>
    @endif
</div>
