<?php declare(strict_types=1);


namespace Viabo\management\commerceTerminal\infrastructure\doctrine;


use Viabo\management\commerceTerminal\domain\TerminalCommerceId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class TerminalCommerceIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return TerminalCommerceId::class;
    }
}