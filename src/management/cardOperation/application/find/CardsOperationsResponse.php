<?php declare(strict_types=1);

namespace Viabo\management\cardOperation\application\find;

use Viabo\shared\domain\bus\query\Response;

final readonly class CardsOperationsResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}
