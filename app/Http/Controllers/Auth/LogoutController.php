<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Tools\Crypter;
use Illuminate\Http\Request;
use App\Services\Validations;
use App\Http\Controllers\ControllerExt;

class LogoutController extends ControllerExt
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
            Validations::UserLogin($request);

            $user = new User();
            $user->user = $request->user;
            $user->contraseña = Crypter::encryptAES($request->pass);
            $user->save();

            return $this->responseOk([], 'Logout exitoso', 201);

        } catch (\Throwable $th) {
            return $this->badResponse($th);
        }
    }
}
