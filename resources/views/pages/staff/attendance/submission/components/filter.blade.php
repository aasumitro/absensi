<div class="card-header-filter">
   <div class="d-flex p-3 float-end">
       <div class="form-group">
           <label for="for_status">STATUS</label>
           <div id="for_status" class="input-group">
               <label for="status"></label><select
                   name="status"
                   wire:model="status"
                   id="status"
                   class="form-control"
                   style="width: 180px; border-radius: 30px 0 0 30px !important; height: 32px !important; font-size:13px; padding: 0 10px !important;"
               >
                   <option value="ALL">Semua</option>
                   <option value="ISSUED">Diajukan</option>
                   <option value="ACCEPTED">Diterima</option>
                   <option value="REJECTED">Ditolak</option>
               </select>
           </div>
       </div>
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
                   <option value="ALL">Semua</option>
                   @foreach($absentTypes as $type)
                       <option value="{{$type->id}}">{{strtoupper($type->description)}} ({{$type->name}})</option>
                   @endforeach
               </select>
           </div>
       </div>
   </div>
</div>
