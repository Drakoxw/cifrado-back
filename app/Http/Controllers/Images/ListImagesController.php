<?php

namespace App\Http\Controllers\Images;

use Illuminate\Http\Request;
use App\Services\AssetsServices;
use App\Http\Controllers\ControllerExt;

class ListImagesController extends ControllerExt
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        try {
            $this->AuthorizationAdmin();
            $imgs = AssetsServices::listImages();
            $resp = [];
            $datosAgrupados = collect($imgs)->groupBy('file')->toArray();
            foreach ($datosAgrupados as $key => $data) {
                $resp[] = [
                    'file' => $key,
                    'dataFiles' => $data
                ];
            }
            return $this->responseOk($resp);
        } catch (\Throwable $th) {
            return $this->badResponse($th);
        }
    }
}
