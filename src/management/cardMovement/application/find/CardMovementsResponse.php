<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class CardMovementsResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}