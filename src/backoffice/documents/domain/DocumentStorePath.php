<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class DocumentStorePath extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }

    public function update(string $value): self
    {
        $value = str_replace('/storage', '', $value);
        return new self("/storage$value");
    }

    public function directory(): string
    {
        return str_replace('/storage', '', $this->value);
    }
}
