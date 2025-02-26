<?php

namespace App\Actions\Pipelines;

use App\Models\Doctor;
use App\Pipelines\FilterByDate;
use App\Pipelines\FilterByName;
use App\Pipelines\FilterByState;


use Illuminate\Pipeline\Pipeline;

class FilterDoctor
{

  // function for filter by name and date
public function execute(?array $filters, $request)

  {
    return app(Pipeline::class)
      ->send(Doctor::query())
      ->through($filters ?: [
        new FilterByName($request->get('name')),
        new FilterByState($request->get('state')),
        new FilterByDate($request->get('date_start'), $request->get('date_end')),

 ])
      ->thenReturn()->paginate(5);
  }
}
