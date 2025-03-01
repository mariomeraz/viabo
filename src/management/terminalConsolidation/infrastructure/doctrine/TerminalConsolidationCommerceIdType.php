<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\infrastructure\doctrine;

use Viabo\management\shared\domain\commerce\CommerceId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class TerminalConsolidationCommerceIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return CommerceId::class;
    }
}
