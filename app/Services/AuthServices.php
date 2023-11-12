<?php

namespace App\Services;

use App\Classes\Entities\AuthorizationEntity;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthServices
{
    private static string $secret_key = 'secret_Hipper';

    private static string $encryptSSL = 'RS256';

    private static string $passphrase = 'ultra_save';

    public static function AudStrict(): string
    {
        $aud = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }
        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return md5($aud);
    }

    private static function Aud(): string
    {
        $aud = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        }
        $aud .= gethostname();
        return md5($aud);
    }

    public static function SignInCertificated(array $data, int $hours = 24)
    {
        if ($keyPrivate = file_get_contents(__DIR__.'/../keys/cifrado-private.pem')) {
            $time = time();
            $dataSecure = self::secured_encrypt($data);
            $keySSL = openssl_pkey_get_private($keyPrivate, self::$passphrase);

            $token = array(
                'iss' => $_SERVER["HTTP_HOST"] ?? 'localhost',
                'exp' => $time + (60 * 60 * $hours),
                'aud' => self::Aud(),
                'user' => $data['name'],
                'rol' => isset($data['rol']) ? $data['rol'] : '',
                'data' => $dataSecure,
            );

            return JWT::encode($token, $keySSL, self::$encryptSSL);
        }
        throw new Exception('No found file : keys/key.public.pem');
    }

    public static function getData(string $token): AuthorizationEntity
    {
        if (file_get_contents(__DIR__ . '/../keys/cifrado-public.pem')) {

            $keyPublic = openssl_get_publickey(file_get_contents(__DIR__ . '/../keys/cifrado-public.pem'));

            if ($keyPublic) {

                $dataToken = JWT::decode($token, new Key($keyPublic, self::$encryptSSL));
                $data = self::secured_decrypt((string)$dataToken->data);
                return new AuthorizationEntity($data);
            }
            throw new Exception('No found key public');
        }
        throw new Exception('No found file : keys/key.public.pem');
    }

    static function secured_decrypt(string $inputData)
    {
        $first_key = base64_decode(self::$secret_key);
        $second_key = base64_decode(self::$passphrase);
        $cypherMethod = 'AES-256-CBC';

        $mix = base64_decode($inputData);
        $iv_length = openssl_cipher_iv_length($cypherMethod);
        $ivX = substr($mix,0,$iv_length);
        $second_encryptedX = substr($mix,$iv_length,32);
        $first_encryptedX = substr($mix,$iv_length+32);

        $data = openssl_decrypt($first_encryptedX, $cypherMethod,$first_key ,OPENSSL_RAW_DATA ,$ivX);
        $second_encrypted_new = hash_hmac('sha256', utf8_encode($first_encryptedX), $second_key, true);

        if ($second_encryptedX == $second_encrypted_new) {
            return unserialize($data);
        }
        return false;
    }

    private static function secured_encrypt(array $data)
    {
        $first_key = base64_decode(self::$secret_key);
        $second_key = base64_decode(self::$passphrase);
        $cypherMethod = 'AES-256-CBC';

        $dataToEncrypt = serialize($data);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cypherMethod));

        $first_encrypted = openssl_encrypt($dataToEncrypt, $cypherMethod, $first_key, OPENSSL_RAW_DATA, $iv);
        $second_encrypted = hash_hmac('sha256', utf8_encode($first_encrypted), $second_key, true);
        $output = base64_encode($iv . $second_encrypted . $first_encrypted);
        return $output;
    }
}
