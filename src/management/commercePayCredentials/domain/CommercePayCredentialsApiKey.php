<?php declare(strict_types=1);

namespace Viabo\management\commercePayCredentials\domain;

use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayCredentialsApiKey extends StringValueObject
{
    public function valueDecrypt(): string
    {
        return Crypt::decrypt($this->value);
    }
}
