<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\create;


use Viabo\backoffice\commission\domain\Commission;
use Viabo\backoffice\commission\domain\CommissionRepository;
use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CommissionRecorder
{
    public function __construct(private CommissionRepository $repository , private EventBus $bus)
    {
    }

    public function __invoke(
        string $updateByUser ,
        string $commerceId ,
        float  $speiInCarnet ,
        float  $speiInMasterCard ,
        float  $speiOutCarnet ,
        float  $speiOutMasterCard ,
        float  $pay ,
        float  $sharedTerminal
    ): void
    {
        $commission = $this->repository->search(CompanyId::create($commerceId));

        if (empty($commission)) {
            $commission = Commission::create(
                $commerceId ,
                $speiInCarnet ,
                $speiInMasterCard ,
                $speiOutCarnet ,
                $speiOutMasterCard ,
                $pay ,
                $sharedTerminal ,
                $updateByUser
            );
            $this->repository->save($commission);
        } else {
            $commission->update(
                $speiInCarnet ,
                $speiInMasterCard ,
                $speiOutCarnet ,
                $speiOutMasterCard ,
                $pay ,
                $sharedTerminal ,
                $updateByUser
            );
            $this->repository->update($commission);
        }

        $this->bus->publish(...$commission->pullDomainEvents());
    }
}