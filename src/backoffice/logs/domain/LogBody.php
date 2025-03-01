<?php declare(strict_types=1);


namespace Viabo\backoffice\logs\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class LogBody extends StringValueObject
{
    public static function create(array $data): static
    {
        return new static(json_encode($data));
    }
}