<?php declare(strict_types=1);


namespace Viabo\security\user\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class UserPasswordNotSecurityLevel extends DomainError
{
    public function __construct(protected $message)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "La contraseña no cumple con nivel de seguridad requerida: $this->message";
    }
}
