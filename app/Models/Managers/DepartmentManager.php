<?php

namespace App\Models\Managers;

 use App\Models\Department;
 use Illuminate\Support\Facades\Cache;

 trait DepartmentManager
 {
     private string $fetch_department_key = 'livewire_trait_department_list';

     protected function fetchDepartments()
     {
         return Cache::remember($this->fetch_department_key, $this->cache_time, function ()
         {
             return Department::all() ;
         });
     }
 }
