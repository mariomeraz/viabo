<?php declare(strict_types=1);


namespace Viabo\stp\bank\application\find_bank_by_code;


use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\stp\bank\application\BankResponse;
use Viabo\stp\bank\domain\BankRepository;
use Viabo\stp\bank\domain\exceptions\BankNotExist;

final readonly class BankFinderByCode
{
    public function __construct(private BankRepository $repository)
    {
    }

    public function __invoke(string $bankCode): BankResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'code.value', 'operator' => '=', 'value' => $bankCode]
        ]);
        $bank = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($bank)) {
            throw new BankNotExist();
        }

        return new BankResponse($bank[0]->toArray());
    }
}