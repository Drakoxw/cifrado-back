<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Secure\Crypter;
use Illuminate\Http\Request;
use App\Classes\DTOs\AuthDTO;
use App\Services\Validations;
use App\Services\AuthServices;
use App\Http\Controllers\ControllerExt;

class LoginController extends ControllerExt
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

            $passEnc = Crypter::encryptAES($request->pass);
            $user = User::where('user', $request->user)
                        ->where('password', $passEnc)
                        ->first();

            if ($user) {
                $fullName = $user->name . ' ' . $user->lastName;
                $data = [
                    'ip'         => $request->ip(),
                    'name'       => $fullName,
                    'login'      => $user->user,
                    'email'      => $user->user,
                    'document'   => $user->document,
                    'idUser'     => 0,
                    'idInternal' => $user->id,
                    'rol'        => $user->rol,
                    'isAdmin'    => in_array($user->rol, ['SuperAdmin', 'Admin'])
                ];
                $token = AuthServices::SignInCertificated($data);
                $auth = new AuthDTO(
                    userName: $fullName,
                    email: $user->user,
                    rol: $user->rol,
                    idInternal: $user->id,
                    idUser: 0,
                    token: $token
                );

                return $this->responseOk((array)$auth);
            } else {
                throw new \Exception('Credenciales inválidas', 403);
            }
        } catch (\Throwable $th) {
            return $this->badResponse($th);
        }
    }
}
