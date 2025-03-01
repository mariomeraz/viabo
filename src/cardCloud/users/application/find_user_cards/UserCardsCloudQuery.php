<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\find_user_cards;


use Viabo\shared\domain\bus\query\Query;

final readonly class UserCardsCloudQuery implements Query
{
    public function __construct(public string $userId)
    {
    }
}