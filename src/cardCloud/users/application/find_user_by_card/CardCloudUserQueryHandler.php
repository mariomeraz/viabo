<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\find_user_by_card;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudUserQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudUserFinderByCard $finder)
    {
    }

    public function __invoke(CardCloudUserQuery $query): Response
    {
        return $this->finder->__invoke($query->cardId);
    }
}