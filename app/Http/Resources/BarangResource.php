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
            'id' => $this->id,
            'uid' => $this->uid,
            'barcode' => $this->barcode,
            'nama_barang' => $this->nama_barang,
            'kategori' => $this->kategori->nama_kategori,
            'merek' => $this->merek->nama_merek,
            'stok' => $this->stok,
            'harga_jual' => $this->harga_jual,
            'diskon' => $this->diskon
        ];
    }
}
