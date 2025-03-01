<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class DocumentAuthorizationExist extends DomainError
{
    public function __construct(private readonly string $profileName)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "Ya esta autorizado el documento por un $this->profileName";
    }
}