<?php

namespace App\Http\Controllers\Images;

use Illuminate\Http\Request;
use App\Services\Validations;
use App\Services\AssetsServices;
use App\Http\Controllers\ControllerExt;

class AdminImagesController extends ControllerExt
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $this->AuthorizationAdmin();
            Validations::AdminImages($request);

            $quality = 80;
            if($request->quality > 0) {
                $quality = (int)$request->quality;
            }

            if ($request->action == 'delete') {
                $resp = AssetsServices::deleteImage($request->path);
            } else {
                $resp = AssetsServices::replaceImage($request->base64, $request->path, $quality);
            }

            if ($resp->success) {
                return $this->responseOk([], $resp->message);
            }

            throw new \Exception($resp->message);
        } catch (\Throwable $th) {
            return $this->badResponse($th);
        }
    }
}
