<?php


namespace Viabo\shared\domain\email\exceptions;


use Viabo\shared\domain\DomainError;

final class EmailNotSend extends DomainError
{
    public function __construct(protected $message)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 452;
    }

    public function errorMessage(): string
    {
        return "No fue posible enviar el correo : $this->message";
    }
}