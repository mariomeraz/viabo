<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\find_user_cards;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UserCardsCloudQueryHandler implements QueryHandler
{
    public function __construct(private UserCardsCloudFinder $finder)
    {
    }

    public function __invoke(UserCardsCloudQuery $query): Response
    {
        return $this->finder->__invoke($query->userId);
    }
}