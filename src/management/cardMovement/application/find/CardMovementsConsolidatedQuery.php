<?php declare(strict_types=1);

namespace Viabo\management\cardMovement\application\find;

use Viabo\shared\domain\bus\query\Query;

final readonly class CardMovementsConsolidatedQuery implements Query
{
    public function __construct(
        public array  $card,
        public string $startDate,
        public ?array $movementsConciliated
    )
    {
    }
}
