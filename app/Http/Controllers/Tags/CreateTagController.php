<?php

namespace App\Http\Controllers\Tags;

use App\Models\TagsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerExt;

class CreateTagController extends ControllerExt
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
            $tag = strtoupper($request->name);

            if ($tag == '') {
                throw new \Exception('La etiqueta no puede estar vacía!', 406);
            }
            TagsModel::insert(['name' => $tag]);

            return $this->responseOk([], 'Nueva etiqueta creada!', 201);

        } catch (\Throwable $th) {
            return $this->badResponse($th);
        }
    }
}
