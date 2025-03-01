<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\domain;

use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayStatusId extends StringValueObject
{

    private const PENDING = '6';
    private const APPROVED = '7';

    public static function pending(): static
    {
        return new static(self::PENDING);
    }

    public function isApproved(): bool
    {
        return $this->value === self::APPROVED;
    }
}
