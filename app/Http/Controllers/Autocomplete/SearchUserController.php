<?php

namespace App\Http\Controllers\Autocomplete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class SearchUserController extends Controller
{
    // ! getPermissions for select in primeVue4
    public function getPermissions()
    {
        $permissions = Permission::select('id', 'name')->get();
        return response()->json($permissions);
    }
}
