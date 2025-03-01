<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\domain;

use Viabo\management\terminalTransactionLog\domain\exceptions\CommercePayTransactionOperationIdEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayTransactionOperationId extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CommercePayTransactionOperationIdEmpty();
        }
    }
}
