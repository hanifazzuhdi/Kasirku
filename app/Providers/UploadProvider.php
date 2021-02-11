<?php

namespace App\Providers;

use Illuminate\Http\Request;
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
        }

        $response = cloudinary()->upload("data:image/png;base64,$image")->getSecurePath();

        return $response;
    }
}
