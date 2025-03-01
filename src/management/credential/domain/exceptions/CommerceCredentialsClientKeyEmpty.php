<?php declare(strict_types=1);


namespace Viabo\management\credential\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CommerceCredentialsClientKeyEmpty extends DomainError
{
    public function __construct(private readonly string $clientKeyName)
    {
        parent::__construct();

    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "No esta definida la client key de {$this->clientKeyName}";
    }
}