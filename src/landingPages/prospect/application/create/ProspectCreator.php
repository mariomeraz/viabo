<?php declare(strict_types=1);


namespace Viabo\landingPages\prospect\application\create;


use Viabo\landingPages\prospect\domain\exceptions\ProspectExist;
use Viabo\landingPages\prospect\domain\Prospect;
use Viabo\landingPages\prospect\domain\ProspectRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class ProspectCreator
{
    public function __construct(
        private ProspectRepository $repository,
        private EventBus $bus
    )
    {
    }

    public function __invoke(
        string $businessType ,
        string $name ,
        string $lastname ,
        string $company ,
        string $email ,
        string $phone ,
        string $contactMethod
    ): void
    {
        $this->ensureEmail($email);

        $prospect = Prospect::create(
            $businessType ,
            $name ,
            $lastname ,
            $company ,
            $email ,
            $phone ,
            $contactMethod ,
        );

        $this->repository->save($prospect);

        $this->bus->publish(...$prospect->pullDomainEvents());
    }

    private function ensureEmail(string $email): void
    {
        $prospect = $this->repository->searchEmail($email);

        if(!empty($prospect)){
            throw new ProspectExist();
        }
    }
}