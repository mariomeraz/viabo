<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\create;


use Viabo\backoffice\company\domain\Company;
use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\company\domain\CompanyTradeName;

final readonly class InformalCommerceCreator
{
    public function __construct(private CompanyRepository $repository)
    {
    }

    public function __invoke(CompanyTradeName $commerceTradeName): void
    {
        $commerce = Company::createInformal($commerceTradeName);
        $this->repository->save($commerce);
    }
}