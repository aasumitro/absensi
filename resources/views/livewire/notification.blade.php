<div>
    <li class="nav-item dropdown">
        <a
            class="nav-link text-dark me-lg-3 icon-notifications dropdown-toggle"
            data-unread-notifications="{{ (($notifications->count() > 0) ? "true" : "false") }}"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <span class="icon icon-sm">
                <span class="fas fa-bell bell-shake"></span>
                <span class="icon-badge rounded-circle unread-notifications"></span>
            </span>
        </a>
        <div class="dropdown-menu dashboard-dropdown dropdown-menu-lg dropdown-menu-center mt-2 py-0">
            <div class="list-group list-group-flush">
                <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">
                    Notifikasi
                </a>
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        @if((int)$notification->department_id === auth()->user()->profile->department_id)
                            @php($data = json_decode($notification->data))
                            <a href="{{route('staff.attendance.verify-submission')}}" class="list-group-item list-group-item-action border-bottom border-light">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img
                                            alt="Image placeholder"
                                            src="{{default_profile_picture($data->name)}}"
                                            class="user-avatar lg-avatar rounded-circle"
                                        >
                                    </div>
                                    <div class="col ps-0 ms-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="h6 mb-0 text-small">{{$data->name}}</h4>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-danger">
                                                    {{\Carbon\Carbon::createFromDate($notification->datetime)->diffForHumans()}}
                                                </small>
                                            </div>
                                        </div>
                                        <p class="font-small mt-1 mb-0">
                                            {{$data->description}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @else
                            <div class="text-center my-3">Tidak ada notifikasi baru</div>
                        @endif
                    @endforeach
                @else
                    <div class="text-center my-3">Tidak ada notifikasi baru</div>
                @endif
                <p class="dropdown-item text-center text-primary fw-bold rounded-bottom py-3"></p>
            </div>
        </div>
    </li>
</div>
