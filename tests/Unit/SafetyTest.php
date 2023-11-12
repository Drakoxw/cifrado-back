<?php

namespace Tests\Unit;

use App\Secure\Crypter;
use App\Services\AuthServices;
use PHPUnit\Framework\TestCase;
use App\Classes\Entities\AuthorizationEntity;

class SafetyTest extends TestCase
{

    public function test_encrypt_password()
    {
        $password = 'XXXX-000000000-a';
        $hash = Crypter::encryptAES($password);
        $this->assertIsString($hash);
        $this->assertEquals($password,Crypter::decryptAES($hash));
        $hash2 = Crypter::encryptRSA($password);
        $this->assertIsString($hash2);
        $this->assertEquals($password,Crypter::decryptRSA($hash2));
    }

    public function test_create_token()
    {
        $data = [
            'ip'         => '000000000',
            'name'       => 'test',
            'login'      => 'test',
            'email'      => 'test',
            'document'   => 1,
            'idUser'     => 1,
            'idInternal' => 1,
            'rol'        => 1,
            'isAdmin'    => true
        ];
        $token = AuthServices::SignInCertificated($data);
        $this->assertIsString($token);
    }

    public function test_decode_token()
    {
        $data = [
            'ip'         => '000000000',
            'name'       => 'test',
            'login'      => 'test',
            'email'      => 'test',
            'document'   => 1,
            'idUser'     => 1,
            'idInternal' => 1,
            'rol'        => 1,
            'isAdmin'    => true
        ];
        $token = AuthServices::SignInCertificated($data);
        $dataToken = AuthServices::getData($token);
        print_r($dataToken);
        $this->assertInstanceOf(AuthorizationEntity::class, $dataToken);
    }
}
