<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StokResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uid' => $this->uid,
            'nama_barang' => $this->nama_barang,
            'barcode' => $this->barcode,
            'stok' => $this->stok,
            'diperbarui' => $this->updated_at
        ];
    }
}
