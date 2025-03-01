<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\domain;

use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayTransactionStatusId extends StringValueObject
{

    private const CHARGED = '7';
    private const REFUSED = '8';

    public function charged(): static
    {
        return new static(self::CHARGED);
    }

    public function refused(): static
    {
        return new static(self::REFUSED);
    }
}
