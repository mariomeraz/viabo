<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CardMovementChecked extends DomainError
{
    private string $value;

    public function __construct(string $value = '')
    {
        $this->value = $value;
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "El movimiento de la tarjeta $this->value ya esta comprobado";
    }
}