<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\backoffice\company\domain\CompanyRepository;

final readonly class CommerceIdFinder
{
    public function __construct(private CompanyRepository $repository)
    {
    }

    public function __invoke(string $userId , string $userProfileId): CommerceIdResponse
    {
        $commerceId = $this->repository->searchCommerceIdBy($userId , $userProfileId);
        return new CommerceIdResponse($commerceId);
    }
}