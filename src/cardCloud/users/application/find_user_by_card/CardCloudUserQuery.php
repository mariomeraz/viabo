<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\find_user_by_card;


use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudUserQuery implements Query
{
    public function __construct(public string $cardId)
    {
    }
}