<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\application\create;


use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\stp\externalAccount\domain\exceptions\ExternalAccountExist;
use Viabo\stp\externalAccount\domain\ExternalAccount;
use Viabo\stp\externalAccount\domain\ExternalAccountRepository;

final readonly class ExternalAccountCreator
{
    public function __construct(private ExternalAccountRepository $repository , private EventBus $bus)
    {
    }

    public function __invoke(
        string $userId ,
        string $interbankCLABE ,
        string $beneficiary ,
        string $rfc ,
        string $alias ,
        string $bankId ,
        string $email ,
        string $phone
    ): void
    {
        $this->ensureInterbankCLABE($interbankCLABE, $userId);

        $externalAccount = ExternalAccount::create(
            $userId ,
            $interbankCLABE ,
            $beneficiary ,
            $rfc ,
            $alias ,
            $bankId ,
            $email ,
            $phone
        );

        $this->repository->save($externalAccount);

        $this->bus->publish(...$externalAccount->pullDomainEvents());
    }

    private function ensureInterbankCLABE(string $interbankCLABE, string $userId): void
    {
        $filters = Filters::fromValues([
            ['field' => 'interbankCLABE.value' , 'operator' => '=' , 'value' => $interbankCLABE],
            ['field' => 'createdByUser.value' , 'operator' => '=' , 'value' => $userId],
            ['field' => 'active.value', 'operator' => '=', 'value' => '1']
        ]);

        $externalAccount = $this->repository->searchCriteria(new Criteria($filters));

        if (!empty($externalAccount)) {
            throw new ExternalAccountExist();
        }
    }
}