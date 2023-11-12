<?php

namespace App\Traits;

use App\Classes\Entities\AuthorizationEntity;
use App\Services\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait HeadersTrait
{
    /** @property token tokenString q llame a $this->Authorization() */
    public string $token;

    /**
     * Accede al token para retornar los datos del token procesados y el token string hacerlo publico desde el controlador
     *  * Da acceso a $this->token
     *
     * @param  Request  $request [explicite description]
     * @throws \Exception
     */
    public function Authorization(Request $request = null): AuthorizationEntity
    {
        if ($request == null) {
            $request = request();
        }

        $token = $request->header('Authorization')
            ?? $request->request->get('Authorization');

        if (! $token) {
            throw new \Exception('Token does not exist', Response::HTTP_UNAUTHORIZED);
        }

        $this->token = $token;

        $this->AuthEntity = AuthServices::getData($token);
        return $this->AuthEntity;
    }

    public function AuthorizationAdmin(Request $request = null): AuthorizationEntity
    {
        $this->Authorization($request);
        if (! $this->AuthEntity->isAdmin) {
            throw new \Exception('Token does not exist', Response::HTTP_UNAUTHORIZED);
        }

        return $this->AuthEntity;
    }

    public function TimeOut(int $defaultTime = 20): int
    {
        $request = request();
        if ($request->get('timeOut')) {
            return intval($request->get('timeOut'));
        }

        $dsTime = ['timeOut', 'TimeOut', 'timeout', 'TIMEOUT'];
        $header = [...$request->request];
        foreach ($dsTime as $t) {
            if ($request->header($t)) {
                return intval($request->header($t));
            }
            if (isset($header[$t])) {
                return intval($header[$t]);
            }
        }

        return $defaultTime;
    }
}
