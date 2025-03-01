<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\find;


use Viabo\backoffice\commission\domain\Commission;
use Viabo\backoffice\commission\domain\CommissionRepository;
use Viabo\backoffice\shared\domain\company\CompanyId;

final readonly class CommissionChargeFinder
{
    public function __construct(private CommissionRepository $repository)
    {
    }

    public function __invoke(CompanyId $commerceId , string $paymentProcessor , float $amount): CommissionResponse
    {
        $commission = $this->repository->search($commerceId);

        if (empty($commission)) {
            $commission = Commission::empty($commerceId);
            $this->repository->save($commission);
        }

        $commission->calculateInputFor($paymentProcessor , $amount);

        return new CommissionResponse($commission->charge()->toArray());
    }
}