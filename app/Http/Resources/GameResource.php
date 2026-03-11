<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public $status;
    public $message;
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function __construct($status,$message,$resource) //digunakan untuk pemanggilan pada controller untuk mengirimkan nilai variabel
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    public function toArray(Request $request): array //return response jsonnya
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'konten' => $this->resource
        ];

    }
}
