<?php

namespace App\Models\Managers;

 use App\Models\Department;
 use Illuminate\Support\Facades\Cache;

 trait DepartmentManager
 {
     protected function fetchDepartments()
     {
         return Department::all() ;
     }
 }
