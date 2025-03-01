<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\application\create;

use Viabo\management\shared\domain\commerce\CommerceId;
use Viabo\management\terminalConsolidation\domain\services\ValidatorTerminalConsolidation;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidation;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationReferenceNumber;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationRepository;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationSpeiCardTransactionAmount;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationSpeiCardTransactionId;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationTerminalId;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationUserId;

final readonly class CreateTerminalConsolidation
{
    public function __construct(
        private TerminalConsolidationRepository $repository,
        private ValidatorTerminalConsolidation $validator
    )
    {
    }

    public function __invoke(
        CommerceId                                     $commerceId,
        TerminalConsolidationUserId                    $userId,
        TerminalConsolidationTerminalId                $terminalId,
        TerminalConsolidationSpeiCardTransactionId     $speiCardTransactionId,
        TerminalConsolidationSpeiCardTransactionAmount $speiCardTransactionAmount,
        array                                          $transactions,
        mixed                                          $threshold
    ):void
    {
        $this->validator->__invoke($speiCardTransactionAmount,$threshold,$transactions);

        $referenceNumber = TerminalConsolidationReferenceNumber::random();

        foreach ($transactions as $transaction) {
            $terminalConsolidation = TerminalConsolidation::create(
                $commerceId,
                $speiCardTransactionId,
                $speiCardTransactionAmount,
                $terminalId,
                $userId,
                $referenceNumber,
                $transaction['transactionId'],
                $transaction['amount'],
            );

            $this->repository->save($terminalConsolidation);
        }

    }




}
