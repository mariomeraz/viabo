<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardOperationOriginMain extends StringValueObject
{
    public function value(): string
    {
        return empty($this->value) ? '0' : $this->value;
    }

}