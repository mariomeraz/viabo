<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\find;

use Viabo\management\terminalTransaction\domain\CommercePayReferenceId;
use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;

final readonly class CommercePayUrlCodeFinder
{
    public function __construct (private TerminalTransactionRepository $repository)
    {
    }

    public function __invoke(CommercePayReferenceId $referenceId): FindCommercePayUrlCodeResponse
    {
        $commercePay = $this->repository->searchBy($referenceId);
        $commercePayData = $commercePay->toArray();

        return new FindCommercePayUrlCodeResponse([
            'urlCode' => $commercePayData['urlCode']
        ]);
    }
}
