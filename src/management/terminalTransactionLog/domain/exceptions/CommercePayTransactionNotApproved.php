<?php declare(strict_types=1);


namespace Viabo\management\terminalTransactionLog\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CommercePayTransactionNotApproved extends DomainError
{
    public function __construct(string $message)
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
        return "Error en la transacción: {$this->message}";
    }
}