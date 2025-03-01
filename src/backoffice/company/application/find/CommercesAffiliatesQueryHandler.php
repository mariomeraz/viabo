<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CommercesAffiliatesQueryHandler implements QueryHandler
{
    public function __construct(private CommercesAffiliatesFinder $finder)
    {
    }

    public function __invoke(CommercesAffiliatesQuery $query): Response
    {
        return ($this->finder)();
    }
}