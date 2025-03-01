<?php declare(strict_types=1);


namespace Viabo\management\credential\domain;


use Viabo\management\credential\domain\exceptions\CommerceCredentialsClientKeyEmpty;
use Viabo\management\credential\domain\exceptions\CommerceCredentialsKeyCompanyEmpty;

final class CommerceCredentials
{
    public function __construct(
        private string $companyKey ,
        private string $masterCardKey ,
        private string $carnetKey ,
        private string $clientKey
    )
    {
    }

    public static function create(
        string $mainKey ,
        string $masterCardKey ,
        string $carnetKey
    ): static
    {
        static::validate($mainKey , $masterCardKey , $carnetKey);
        return new static($mainKey , $masterCardKey , $carnetKey , '');
    }

    public static function empty(): static
    {
        return new static('' , '' , '' , '');
    }

    private static function validate(
        string $mainKey ,
        string $masterCardKey ,
        string $carnetKey
    ): void
    {
        if (empty($mainKey)) {
            throw new CommerceCredentialsKeyCompanyEmpty();
        }

        if (empty($masterCardKey)) {
            throw new CommerceCredentialsClientKeyEmpty('mastercard');
        }

        if (empty($carnetKey)) {
            throw new CommerceCredentialsClientKeyEmpty('carnet');
        }
    }

    public function clientKey(): string
    {
        return $this->clientKey;
    }

    public function companyKey(): string
    {
        return $this->companyKey;
    }

    public function setClientKey(string $paymentProcessorId): void
    {
        $masterCardId = '1';
        if ($paymentProcessorId === $masterCardId) {
            $this->clientKey = $this->masterCardKey;
        }

        $carnetId = '2';
        if ($paymentProcessorId === $carnetId) {
            $this->clientKey = $this->carnetKey;
        }
    }
}