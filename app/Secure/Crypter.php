<?php

namespace App\Secure;

class Crypter
{
    private static $secret_key = 'DH6wsB2l5oNfbgjuEDTyO7p2onttIfnmQKBg';

    private static $secret_iv = 'iKMbGrJgvEjyfb0y';

    private static $method = 'AES-256-CBC';

    public static function decryptRSA(string $value): string
    {
        $decrypted = '';
        $privateGet = openssl_get_privatekey(file_get_contents(dirname(__FILE__).'/../keys/private-key.pem'));
        $private_key = openssl_pkey_get_private($privateGet);
        $encrypted = base64_decode($value);
        openssl_private_decrypt($encrypted, $decrypted, $private_key);

        return $decrypted;
    }

    public static function encryptRSA(string $value): string
    {
        $key_resource = openssl_get_publickey(file_get_contents(dirname(__FILE__).'/../keys/public-key.pem'));
        openssl_public_encrypt($value, $crypttext, $key_resource);
        $encrypted = base64_encode($crypttext);

        return $encrypted;
    }

    public static function encryptAES(string $value): string
    {
        $iv = substr(hash('sha256', self::$secret_iv), 0, 16);
        $key = hash('sha256', self::$secret_key);

        return base64_encode(openssl_encrypt($value, self::$method, $key, 0, $iv));
    }

    public static function decryptAES(string $value): string
    {
        $iv = substr(hash('sha256', self::$secret_iv), 0, 16);
        $key = hash('sha256', self::$secret_key);
        $output = openssl_decrypt(base64_decode($value), self::$method, $key, 0, $iv);
        if ($output == false) {
            $output = '';
        }

        return $output;
    }
}
