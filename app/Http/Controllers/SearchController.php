<?php

namespace App\Http\Controllers;

use App\Actions\Pipelines\FilterDoctor;
use App\Pipelines\FilterByName;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function viewSearch()
    {
        return Inertia::render('ViewSearch');
    }
}
