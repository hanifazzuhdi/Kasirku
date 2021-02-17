<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanKasir extends JsonResource
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
            'harga_total' => $this->harga_total,
            'dibayar' => $this->dibayar,
            'kembalian' => $this->kembalian,
            'kode_member' => $this->kode_member,
            'kasir' => $this->kasir->nama,
            'created_at' => $this->created_at
        ];
    }
}
