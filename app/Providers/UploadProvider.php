<?php

namespace App\Providers;

use Illuminate\Http\Request;

use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\ServiceProvider;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\Facades\DNS2DFacade;

class UploadProvider extends ServiceProvider
{
    public static function upload(Request $request)
    {
        $image = base64_encode(file_get_contents($request->file('avatar')));

        $client = new GuzzleHttpClient();
        $response = $client->request('POST', 'https://api.imgbb.com/1/upload', [
            'form_params' => [
                'key' => 'f98a15c0e84720165f5cd99516022338',
                'image' => $image,
                'name' => $request
            ]
        ]);
        $res = json_decode($response->getBody()->getContents(), true);

        return $res['data']['url'];
    }

    public static function uploadCode($request, $type)
    {
        if ($type == 'register') {
            $image = DNS2DFacade::getBarcodePNG($request, 'QRCODE');
        } else {
            $image = DNS1DFacade::getBarcodePNG($request, 'C39', 1, 34, array(1, 1, 1), true);
        }

        $client = new GuzzleHttpClient();
        $response = $client->request('POST', 'https://api.imgbb.com/1/upload', [
            'form_params' => [
                'key' => 'f98a15c0e84720165f5cd99516022338',
                'image' => $image,
                'name' => $request
            ]
        ]);
        $res = json_decode($response->getBody()->getContents(), true);

        return $res['data']['url'];
    }
}
