<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\domain;


use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class StpAccountKey extends StringValueObject
{
    public function decrypt(): string
    {
        return Crypt::decrypt($this->value);
    }
}