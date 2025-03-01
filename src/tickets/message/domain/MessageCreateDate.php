<?php declare(strict_types=1);


namespace Viabo\tickets\message\domain;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class MessageCreateDate extends DateTimeValueObject
{
    public function diffNow(): string
    {
        return $this->date->diffNow($this->value);
    }
}