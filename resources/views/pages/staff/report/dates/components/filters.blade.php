<div class="card-header-filter">
    <div class="d-flex p-3 float-end">
        <div class="form-group ms-3">
            <label for="for_date">TANGGAL</label>
            <div id="for_date" class="d-flex">
                <label for="date_from"></label><input
                    wire:model="from_date"
                    type="date"
                    class="form-control ml-2 datepicker"
                    name="from_date"
                    id="date_from"
                    value="{{ (app('request')->input('from_date')) ?? ''}}"
                    style="border-radius: 30px 0 0 30px !important; height: 33px !important; font-size:13px; padding: 0 10px !important; -webkit-appearance: none;"
                >
                <label for="date_to"></label><input
                    wire:model="to_date"
                    type="date"
                    class="form-control datepicker"
                    name="to_date"
                    id="date_to"
                    value="{{ (app('request')->input('to_date')) ?? ''}}"
                    style="border-radius: 0 0 0 0 !important; height: 33px !important; font-size:13px; padding: 0 10px !important; -webkit-appearance: none;"
                >
            </div>
        </div>
        <div class="form-group ms-3">
            <label for="for_absent_type">TIPE</label>
            <div id="for_absent_type" class="input-group">
                <label for="absent_type_id"></label><select
                    name="absent_type_id"
                    wire:model="absent_type_id"
                    id="absent_type_id"
                    class="form-control"
                    style="width: 180px; border-radius: 30px 0 0 30px !important; height: 32px !important; font-size:13px; padding: 0 10px !important;"
                >
                    <option value="ALL">SEMUA DATA</option>
                    <option value="ATTEND">SEMUA HADIR</option>
                    <option value="ABSENT">SEMUA IZIN</option>
                    @foreach($absentTypes as $type)
                        <option value="{{$type->id}}">IZIN : {{strtoupper($type->description)}} ({{$type->name}})</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($attendances)
            @if($attendances->count() > 0)
                <div class="btn-group h-25 mt-4 ms-3">
                    <button
                        type="button"
                        class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                        id="dropdownMenuReference"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        data-bs-reference="parent"
                    >
                        <span class="px-2">
                            Export Data
                            <i class="fas fa-file-export ps-2"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu py-0" aria-labelledby="dropdownMenuReference">
                        <li>
                            <a wire:click.prevent="performExportData('xls')" class="dropdown-item rounded-top" href="#">
                                Dalam bentuk Excel (<code class="text-danger">.xls</code>)
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a wire:click.prevent="performExportData('csv')" class="dropdown-item rounded-bottom" href="#">
                                Dalam bentuk CSV (<code class="text-danger">.csv</code>)
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        @endif
    </div>
</div>
