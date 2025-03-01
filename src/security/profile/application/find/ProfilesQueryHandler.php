<?php declare(strict_types=1);


namespace Viabo\security\profile\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class ProfilesQueryHandler implements QueryHandler
{
    public function __construct(private ProfilesFinder $finder)
    {
    }

    public function __invoke(ProfilesQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}