<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ZoneResource extends JsonResource
{

    // ! using the timeZone is redundant because it is already set in the .env


    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => Carbon::parse($this->created_at)->setTimezone('America/Lima')->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->setTimezone('America/Lima')->format('Y-m-d H:i:s'),
        ];
    }
}
