<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class CommerceCredentialQuery implements Query
{
    public function __construct(public string $commerceId)
    {
    }
}