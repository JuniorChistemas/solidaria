<?php


namespace App\Actions\Pipelines;

use App\Models\Laboratory;
use App\Pipelines\FilterByName;
use App\Pipelines\FilterByState;
use Illuminate\Pipeline\Pipeline;

class Filter
{

  // function for filter by name and date
  public function execute(array $filters, $request)
  {
    return app(Pipeline::class)
      ->send(Laboratory::query())
      ->through($filters ?: [
        new FilterByName($request->get('name')),
        new FilterByState($request->get('state')),
      ])
      ->thenReturn()->paginate(5);
  }
}
