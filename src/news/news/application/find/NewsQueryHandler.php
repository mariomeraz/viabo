<?php declare(strict_types=1);


namespace Viabo\news\news\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class NewsQueryHandler implements QueryHandler
{
    public function __construct(private NewsFinder $finder)
    {
    }

    public function __invoke(NewsQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}