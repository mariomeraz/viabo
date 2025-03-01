<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\domain;


use Viabo\shared\domain\utils\URL;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class BusinessDomain extends StringValueObject
{
    public function host(): string
    {
        return empty($this->value) ? '' : URL::protocol() . $this->value;
    }
}