<?php declare(strict_types=1);


namespace Viabo\management\credential\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardCredentialDecryptQuery implements Query
{
    public function __construct(public string $password , public string $cardId)
    {
    }
}