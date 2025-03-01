<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\find;


use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;
use Viabo\management\terminalTransaction\domain\exceptions\CommercePayUrlCodeNotExist;

final readonly class CommercePayFinder
{
    public function __construct(private TerminalTransactionRepository $repository)
    {
    }

    public function __invoke(CommercePayId $commercePayId): CommercePayResponse
    {
        $commercePay = $this->repository->searchView($commercePayId);

        if(empty($commercePay)){
            throw new CommercePayUrlCodeNotExist();
        }

        return new CommercePayResponse($commercePay->toArray());
    }
}