<?php declare(strict_types=1);


namespace Viabo\security\profile\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class ProfileQueryHandler implements QueryHandler
{
    public function __construct(private ProfileFinder $finder)
    {
    }

    public function __invoke(ProfileQuery $query): Response
    {
        return $this->finder->__invoke($query->profileId);
    }
}