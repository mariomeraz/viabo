<?php declare(strict_types=1);


namespace Viabo\landingPages\prospect\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ProspectBusinessTypeEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido el tipo de negocio';
    }
}