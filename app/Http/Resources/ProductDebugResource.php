<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDebugResource extends JsonResource
{
    public static $wrap = 'data';
    // public $additional = [
    //     'author' => 'Maria Regina'
    // ];
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'author' => 'Maria Regina',
            'server_time' => now()->toDateTimeString(),
            /*jika ingin additional data dinamis,
            maka kita tambah additional data nya langsung di to array,
            agar dia sejajar dengan data, maka kita perlu mengisi manual wrap 'data' nya
            */  
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
            ]
        ];
    }
}
