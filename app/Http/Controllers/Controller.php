<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Method for send response api
     */

    public function sendResponse($status, $message, $data, $http)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data'  => $data
        ], $http);
    }

    /**
     * Method for format phone number
     */
    public function formatNumber($request)
    {
        if (str_contains($request->input('nomor'), '+62') and str_split($request->input('nomor'), 3)[0] == '+62') {
            $nomor = $request->input('nomor');
        } else {
            $nomor = str_split($request->input('nomor'), 2);

            if ($nomor[0] === '08') {

                unset($nomor[0]);

                $nomor = '+628' . implode($nomor);
            } else {
                return $this->sendResponse('failed', 'input nomor dengan benar', null, 404);
            }
        }

        return $nomor;
    }

    /**
     * Tentukan Waktu
     */
    public function sapa()
    {
        $waktu = date('H');

        switch (true) {
            case $waktu >= '02' and $waktu <= '10':
                $sapa = 'Pagi';
                break;
            case $waktu >= '11' and $waktu <= '15':
                $sapa = 'Siang';
                break;
            case $waktu >= '16' and $waktu <= '18':
                $sapa = 'Petang';
                break;
            default:
                $sapa = 'Malam';
                break;
        }

        return $sapa;
    }
}
