<?php

namespace App\Http\Controllers\Autocomplete;

use App\Actions\Pipelines\FilterDoctor;
use App\Http\Controllers\Controller;
use App\Pipelines\FilterByCode;
use App\Pipelines\FilterByName;
use Illuminate\Http\Request;

class SearchDoctorController extends Controller
{
    public function searchDoctor(Request $request)
    {
        $filter = [
            new FilterByCode($request->get('code')),
        ];
        $doctors = app(FilterDoctor::class)->execute($filter, $request);
        return response()->json($doctors);
    }
}
