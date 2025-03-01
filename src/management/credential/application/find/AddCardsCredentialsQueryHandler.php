<?php declare(strict_types=1);


namespace Viabo\management\credential\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class AddCardsCredentialsQueryHandler implements QueryHandler
{
    public function __construct(private CardsCredentialsFinder $finder)
    {
    }

    public function __invoke(AddCardsCredentialsQuery $query): Response
    {
        return $this->finder->__invoke($query->cards);
    }
}