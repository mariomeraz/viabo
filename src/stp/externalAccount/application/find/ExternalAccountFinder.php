<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\application\find;

use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\stp\externalAccount\domain\exceptions\ExternalAccountNotExist;
use Viabo\stp\externalAccount\domain\ExternalAccountRepository;

final readonly class ExternalAccountFinder
{
    public function __construct(private ExternalAccountRepository $repository)
    {
    }

    public function __invoke(string $externalAccountNumber): ExternalAccountResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'interbankCLABE.value', 'operator' => '=', 'value' => $externalAccountNumber],
            ['field' => 'active.value', 'operator' => '=', 'value' => '1'],
        ]);
        $externalAccount = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($externalAccount)) {
            throw new ExternalAccountNotExist();
        }

        return new ExternalAccountResponse($externalAccount[0]->toArray());
    }
}