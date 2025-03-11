<?php

namespace App\Actions\Pipelines;

use App\Models\Category;
use App\Pipelines\FilterByDate;
use App\Pipelines\FilterByName;
use App\Pipelines\FilterByState;


use Illuminate\Pipeline\Pipeline;

class FilterCategory
{
  public function execute(?array $filters, $request, int $perPage = 10)

  {
    return app(Pipeline::class)
      ->send(Category::query())
      ->through($filters ?: [
        new FilterByName($request->get('name')),
      ])
      ->thenReturn()->paginate($perPage);
  }
}
