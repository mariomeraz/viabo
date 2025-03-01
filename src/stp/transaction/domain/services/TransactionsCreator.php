<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\services;


use Viabo\shared\domain\utils\NumberFormat;
use Viabo\stp\transaction\domain\Transactions;
use Viabo\stp\transaction\domain\TransactionStatusId;

final readonly class TransactionsCreator
{
    public function __construct(
        private TransactionTypeFinder $typeFinder,
        private StatusFinder          $statusFinder,
    )
    {
    }

    public function __invoke(
        array  $originAccount,
        array  $destinationsAccounts,
        string $concept,
        string $userId,
        bool   $isInternalTransaction
    ): Transactions
    {
        $transactionsData = [];
        foreach ($destinationsAccounts as $destinationsAccount) {
            $transactionsData[] = [
                'transactionId' => $destinationsAccount['transactionId'],
                'businessId' => $originAccount['businessId'],
                'transactionType' => $this->typeFinder->speiOutType(),
                'statusId' => $this->getStatusId($destinationsAccount['isInternalTransaction']),
                'concept' => $concept,
                'sourceAccountType' => $originAccount['type'],
                'sourceAccount' => $originAccount['bankAccount'],
                'sourceAcronym' => $originAccount['acronym'] ?? '',
                'sourceName' => $originAccount['name'],
                'sourceEmail' => $originAccount['emails'],
                'sourceBalance' => $originAccount['realBalance'],
                'destinationAccountType' => $destinationsAccount['type'],
                'destinationAccount' => $destinationsAccount['bankAccount'],
                'destinationName' => $destinationsAccount['beneficiary'],
                'destinationEmail' => $destinationsAccount['email'],
                'destinationBalance' => $destinationsAccount['balance'],
                'bankCode' => $destinationsAccount['bankCode'],
                'amount' => NumberFormat::float($destinationsAccount['amount']),
                'commissions' => $originAccount['commissions'],
                'userId' => $userId,
                'additionalData' => [
                    'isInternalTransaction' => $destinationsAccount['isInternalTransaction'],
                    'sourceCompanyId' => $originAccount['companyId'],
                    'sourceRfc' => $originAccount['rfc'],
                    'destinationCompanyId' => $destinationsAccount['companyId'],
                    'destinationRfc' => $destinationsAccount['rfc'],
                    'destinationBankName' => $destinationsAccount['bankName']
                ]
            ];
        }
        return Transactions::fromValues($transactionsData);
    }

    public function getStatusId(bool $isInternalTransaction): TransactionStatusId
    {
        return $isInternalTransaction ?
            $this->statusFinder->liquidated() :
            $this->statusFinder->inTransit();
    }

}