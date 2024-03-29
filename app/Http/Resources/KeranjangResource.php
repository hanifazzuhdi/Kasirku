<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KeranjangResource extends JsonResource
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
            'nama_barang' => $this->nama_barang,
            'harga_satuan' => $this->harga,
            'pcs' => $this->pcs,
            'diskon' => $this->diskon,
            'total_harga' => $this->total_harga
        ];
    }
}
