<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class pemainResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public $resource;
    public $totalElemen;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->totalElemen = count($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'totalElemen' => $this->totalElemen,
            'konten' => $this->resource
        ];
    }
}
