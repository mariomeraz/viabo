<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\infrastructure\doctrine;


use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class CommercePayIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return CommercePayId::class;
    }
}