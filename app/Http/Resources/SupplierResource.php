<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'supplier_name' => $this->supplier_name,
            'ruc' => $this->ruc,
            'phone' => $this->phone,
            'address' => $this->address,
            'created_at' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->start_date)->format('Y-m-d'),
        ];
    }
}
