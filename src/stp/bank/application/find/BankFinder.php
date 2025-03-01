<?php declare(strict_types=1);


namespace Viabo\stp\bank\application\find;


use Viabo\stp\bank\application\BankResponse;
use Viabo\stp\bank\domain\BankRepository;

final readonly class BankFinder
{
    public function __construct(private BankRepository $repository)
    {
    }

    public function __invoke(string $bankId): BankResponse
    {
        $bank = $this->repository->search($bankId);
        return new BankResponse($bank->toArray());
    }
}