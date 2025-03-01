<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardsMovementsQueryByCommerce implements Query
{
    public function __construct(public array $cards , public array|null $filters)
    {
    }
}