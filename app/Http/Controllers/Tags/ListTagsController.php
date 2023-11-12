<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\ControllerExt;
use App\Models\TagsModel;

class ListTagsController extends ControllerExt
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        try {
            $this->AuthorizationAdmin();
            $list = TagsModel::all()->toArray();
            return $this->responseOk($list);

        } catch (\Throwable $th) {
            return $this->badResponse($th);
        }
    }
}
