<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class ExternalAccountsQuery implements Query
{
    public function __construct(public string $userId)
    {
    }
}