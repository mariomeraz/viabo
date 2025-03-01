<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CardOperationCardBlocked extends DomainError
{
    public function __construct(private readonly string $cardNumber)
    {
        parent::__construct();

    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "La tarjeta {$this->cardNumber} esta bloqueada";
    }
}