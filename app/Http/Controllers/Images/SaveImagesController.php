<?php

namespace App\Http\Controllers\Images;

use Illuminate\Http\Request;
use App\Services\Validations;
use App\Services\AssetsServices;
use App\Http\Controllers\ControllerExt;
use Illuminate\Http\Response;

class SaveImagesController extends ControllerExt
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
            $this->Authorization();
            Validations::SaveAssets($request);

            $split = explode('.', $request->nameFile);

            if (isset($split[2])) {
                throw new \Exception("No se aceptan nombres con mas de un punto", Response::HTTP_NOT_ACCEPTABLE);
            }

            $res = AssetsServices::saveImages($request->base64, $request->nameFile);

            if ($res->success === false) {
                throw new \Exception($res->message);
            }

            return response()->json($res->toArray(), Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->badResponse($th);
        }
    }
}
