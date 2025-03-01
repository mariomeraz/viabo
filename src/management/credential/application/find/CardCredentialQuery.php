<?php declare(strict_types=1);


namespace Viabo\management\credential\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardCredentialQuery implements Query
{
    public function __construct(public string $cardId)
    {
    }
}