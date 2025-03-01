<?php declare(strict_types=1);


namespace Viabo\management\commerceTerminal\infrastructure\doctrine;


use Viabo\management\commerceTerminal\domain\TerminalId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class TerminalIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return TerminalId::class;
    }
}