<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

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
}
