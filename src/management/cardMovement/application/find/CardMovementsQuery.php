<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardMovementsQuery implements Query
{
    public function __construct(
        public array  $card ,
        public string $initialDate ,
        public string $finalDate ,
        public array  $operations
    )
    {
    }
}