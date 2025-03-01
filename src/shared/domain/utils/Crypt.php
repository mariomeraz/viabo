<?php declare(strict_types=1);


namespace Viabo\shared\domain\utils;


final class Crypt
{
    private const INITIALIZATION_VECTOR = '19cddc7b35918ee3';

    public static function encrypt(string $value): string
    {
        $ciphertext = openssl_encrypt(
            $value , 'AES-256-CBC' , $_ENV['APP_OPENSSL'] , OPENSSL_RAW_DATA , static::INITIALIZATION_VECTOR
        );
        return base64_encode($ciphertext);
    }

    public static function decrypt(string $value): string
    {
        try {

            if (empty($value)) {
                return '';
            }
            $ciphertext = base64_decode($value);
            $plaintext = openssl_decrypt(
                $ciphertext , 'AES-256-CBC' , $_ENV['APP_OPENSSL'] , OPENSSL_RAW_DATA , static::INITIALIZATION_VECTOR
            );
            return $plaintext === false ? throw new \DomainException() : $plaintext;
        } catch (\DomainException) {
            throw new \DomainException('Error de cifrado' , 406);
        }
    }

    public static function isEncrypt(string $value): bool
    {
        $ciphertext = base64_decode($value);
        $plaintext = openssl_decrypt(
            $ciphertext , 'AES-256-CBC' , $_ENV['APP_OPENSSL'] , OPENSSL_RAW_DATA , static::INITIALIZATION_VECTOR
        );
        return $plaintext !== false ;
    }
}