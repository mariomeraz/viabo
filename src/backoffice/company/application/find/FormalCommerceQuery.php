<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class FormalCommerceQuery implements Query
{
    public function __construct(public string $commerceId)
    {
    }
}