<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\backoffice\company\domain\services\CompanyFinder;
use Viabo\backoffice\shared\domain\commerce\CompanyLegalRepresentative;
use Viabo\backoffice\shared\domain\company\CompanyId;

final readonly class FormalCommerceFinder
{
    public function __construct(private CompanyFinder $finder)
    {
    }

    public function __invoke(CompanyId $commerceId): FormalCommerceResponse
    {
        $legalRepresentative = CompanyLegalRepresentative::empty();
        $commerce = $this->finder->commerce($commerceId , $legalRepresentative);

        if ($commerce->isInformal()) {
            $commerce = $this->finder->commerce(new CompanyId($commerce->father()->value()) , $legalRepresentative);
        }
        return new FormalCommerceResponse($commerce->toArray());
    }
}