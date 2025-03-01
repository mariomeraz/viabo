<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class StpAccountNotExist extends DomainError
{
    public function __construct(string $message = '')
    {
        $this->message = $message;
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return empty($this->message) ? 'No tiene asignado ninguna credenciales de STP' : $this->message;
    }
}