<?php

namespace App\Pipelines;

use Carbon\Carbon;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class FilterByDate
{
  public function handle(Builder $builder, Closure $next)
  {
    $date_start = request()->input('date_start');
    $date_end = request()->input('date_end');

    if ($date_start && $date_end) {
      Log::info("FilterByDate: $date_start - $date_end");
      $date_start = Carbon::parse($date_start)->startOfDay();
      $date_end = Carbon::parse($date_end)->endOfDay();

      $builder->whereBetween('created_at', [$date_start, $date_end]);
    }

    return $next($builder);
  }
}
