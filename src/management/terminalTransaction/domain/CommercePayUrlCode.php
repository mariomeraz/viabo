<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\domain;

use Viabo\shared\domain\valueObjects\UuidValueObject;

final class CommercePayUrlCode extends UuidValueObject
{

    public function update(): static
    {
        $value = self::random();
        $value->empty();
        return $value;
    }

    private function empty(): void
    {
        $this->value = '';
    }
}
