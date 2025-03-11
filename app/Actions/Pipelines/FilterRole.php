<?php

namespace App\Actions\Pipelines;

use App\Pipelines\FilterByName;
use App\Pipelines\FilterByState;
use Illuminate\Pipeline\Pipeline;
use Spatie\Permission\Models\Role;

class FilterRole
{
  public function execute(?array $filters, $request, int $perPage = 5)
  {
    return app(Pipeline::class)
      ->send(Role::query())
      ->through($filters ?: [
        new FilterByName($request->get('name')),
        new FilterByState($request->get('state')),
      ])
      ->thenReturn()->paginate($perPage);
  }
}
