<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class FilterByState
{

  public function __construct(private ?bool $state) {}


  public function __invoke(Builder $builder, Closure $next)
  {
    if (is_null($this->state)) {
      return $next($builder);
    }

    $builder->where('state', $this->state);
    Log::info("FilterByState: $this->state");
    return $next($builder);
  }
}
