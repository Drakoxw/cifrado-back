<?php

namespace App\Http\Controllers;

use App\Models\UserCifradoModel;
use App\Services\AuthServices;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * @var string
     *
     * @var(name="keySecret", type="string")
     */
    public $keySecret = '4p0EF8M!YT&S6ftg0p4K1WtN';

    public function login(Request $request)
    {
        try {
            if (session()->has('user')) {
                return redirect('/logs');
            }

            $user = $request->input('user');
            $pass = $request->input('pass');

            if (!empty($user) && !empty($pass)) {
                $user = UserCifradoModel::GetUser($user, $pass);

                if (isset($user)) {
                    session(['user' => AuthServices::AudStrict()]);

                    return redirect('logs');
                }
                throw new \Exception('Error en la clave o Usuario');
            } else {
                throw new \Exception('Ingresa usuario y contraseña');
            }
        } catch (\Throwable $e) {
            return view('login', ['error' => $e->getMessage()]);
        }
    }
}
