<?php declare(strict_types=1);

namespace Viabo\management\cardMovement\application\find;

use Viabo\shared\domain\bus\query\Query;

final readonly class CardsMasterMovementsQuery implements Query
{
    public function __construct(
        public array  $cardsInformation,
        public array  $operations,
        public array  $payTransactions,
        public string $initialDate,
        public string $finalDate
    ){
    }
}
