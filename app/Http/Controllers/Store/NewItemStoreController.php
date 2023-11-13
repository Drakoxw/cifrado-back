<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Services\Validations;
use App\Models\ItemsStoreModel;
use App\Http\Controllers\ControllerExt;

class NewItemStoreController extends ControllerExt
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $user = $this->AuthorizationAdmin();
            Validations::NewItemStore($request);

            $item = new ItemsStoreModel();

            $item->name         = $request->name;
            $item->description  = $request->description;
            $item->tags         = $request->tags;
            $item->main_image   = $request->mainImage;
            $item->other_images = $request->otherImages;
            $item->user_id      = $user->idUser;
            $item->save();

            return $this->responseOk($item->toArray(), 'Nuevo item creado!', 201);

        } catch (\Throwable $th) {
            return $this->badResponse($th);
        }
    }
}
