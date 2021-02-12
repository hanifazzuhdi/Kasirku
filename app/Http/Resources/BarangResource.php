<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
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
            'harga_jual' => $this->harga_jual,
            'diskon' => $this->diskon
        ];
    }
}
