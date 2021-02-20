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
        $response = cloudinary()->upload($request->file('avatar')->getRealPath(), [
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto'
            ],
            'crop' => 'limit'
        ])->getSecurePath();

        return $response;
    }

    public static function uploadCode($request, $type)
    {
        if ($type == 'register') {
            $image = DNS2DFacade::getBarcodePNG($request, 'QRCODE');
        } else {
            $image = DNS1DFacade::getBarcodePNG($request, 'C39', 1, 34, array(1, 1, 1), true);

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

        $response = cloudinary()->upload("data:image/png;base64,$image")->getSecurePath();

        return $response;
    }
}
