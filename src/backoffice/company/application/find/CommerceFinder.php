<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\backoffice\company\domain\services\CompanyFinder as CommerceFinderService;
use Viabo\backoffice\shared\domain\commerce\CompanyLegalRepresentative;
use Viabo\backoffice\shared\domain\company\CompanyId;

final readonly class CommerceFinder
{
    public function __construct(private CommerceFinderService $finder)
    {
    }

    public function __invoke(CompanyId $commerceId): CompanyResponse
    {
        $commerce = $this->finder->view($commerceId , CompanyLegalRepresentative::empty());
        return new CompanyResponse($commerce->toArray());
    }
}