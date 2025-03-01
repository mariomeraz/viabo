<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CommerceIdQueryHandler implements QueryHandler
{
    public function __construct(private CommerceIdFinder $finder)
    {
    }

    public function __invoke(CommerceIdQuery $query): Response
    {
        return $this->finder->__invoke($query->userId, $query->userProfileId);
    }
}