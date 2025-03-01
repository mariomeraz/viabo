<?php declare(strict_types=1);


namespace Viabo\tickets\message\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class MessageCreatedByUser extends StringValueObject
{
    public function isSame(string $userId): bool
    {
        return $this->value === $userId;
    }
}