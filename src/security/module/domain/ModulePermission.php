<?php declare(strict_types=1);


namespace Viabo\security\module\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class ModulePermission extends StringValueObject
{
    public function toArray(): array
    {
        return explode(',' , $this->value);
    }
}