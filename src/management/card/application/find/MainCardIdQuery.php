<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class MainCardIdQuery implements Query
{
    public function __construct(public string $commerceId, public ?string $paymentProcessorId)
    {
    }
}