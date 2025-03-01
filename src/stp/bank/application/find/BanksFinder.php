<?php declare(strict_types=1);


namespace Viabo\stp\bank\application\find;


use Viabo\stp\bank\application\BankResponse;
use Viabo\stp\bank\domain\Bank;
use Viabo\stp\bank\domain\BankRepository;

final readonly class BanksFinder
{
    public function __construct(private BankRepository $repository)
    {
    }

    public function __invoke(): BankResponse
    {
        $banks = $this->repository->searchAll();
        return new BankResponse(array_map(function (Bank $bank){
            return $bank->toArray();
        }, $banks));
    }
}