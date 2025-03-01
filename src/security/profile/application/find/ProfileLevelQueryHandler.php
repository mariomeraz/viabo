<?php declare(strict_types=1);


namespace Viabo\security\profile\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class ProfileLevelQueryHandler implements QueryHandler
{
    public function __construct(private ProfileLevelFinder $finder)
    {
    }

    public function __invoke(ProfileLevelQuery $query): Response
    {
        return $this->finder->__invoke($query->profileId);
    }
}