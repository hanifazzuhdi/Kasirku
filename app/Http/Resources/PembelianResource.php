<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PembelianResource extends JsonResource
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
            'supplier' => $this->supplier->nama_supplier,
            'nama_barang' => $this->nama_barang,
            'pcs' => $this->pcs,
            'harga_satuan' => $this->harga_satuan,
            'total_harga' => $this->total_harga,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
