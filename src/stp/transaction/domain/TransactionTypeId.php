<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

class TransactionTypeId extends StringValueObject
{
    private string $id;
    private string $name;

    public static function out(): static
    {
        return new static('1');
    }

    public static function in(): static
    {
        return new static('2');
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isSpeiInType(): bool
    {
        return $this->id === '2';
    }

    public function isSpeiOutType(): bool
    {
        return $this->id === '1';
    }

}