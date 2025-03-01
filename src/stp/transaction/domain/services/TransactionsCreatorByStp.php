<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\services;


use Viabo\shared\domain\utils\NumberFormat;
use Viabo\stp\transaction\domain\Transactions;

final readonly class TransactionsCreatorByStp
{
    public function __construct(
        private TransactionTypeFinder $typeFinder,
        private StatusFinder          $statusFinder,
    )
    {
    }

    public function __invoke(array $transactions, string $stpOperationType): Transactions
    {
        $transactionType = $stpOperationType !== 'speiIn' ?
            $this->typeFinder->speiOutType() :
            $this->typeFinder->speiInType();
        $statusId = $this->statusFinder->liquidated();
        $transactionsData = [];
        foreach ($transactions as $transaction) {
            $transactionsData[] = [
                'businessId' => $transaction['businessId'],
                'concept' => $transaction['conceptoPago'],
                'sourceAccountType' => '',
                'sourceAccount' => $transaction['cuentaOrdenante'],
                'sourceAcronym' => $transaction['claveRastreo'],
                'sourceName' => $transaction['nombreOrdenante'],
                'sourceEmail' => '',
                'sourceBalance' => $transaction['sourceCompany']['balance'],
                'destinationAccountType' => '',
                'destinationAccount' => $transaction['cuentaBeneficiario'],
                'destinationName' => $transaction['nombreBeneficiario'],
                'destinationEmail' => '',
                'destinationBalance' => $transaction['destinationCompany']['balance'],
                'bankCode' => $transaction['institucionOrdenante'] ?? $transaction['institucionOperante'],
                'amount' => NumberFormat::float($transaction['monto']),
                'commissions' => $transaction['commissions'],
                'liquidationDate' => $transaction['tsLiquidacion'],
                'urlCEP' => $transaction['urlCEP'] ?? '',
                'stpId' => $transaction['id'],
                'api' => $transaction['api'],
                'userId' => '',
                'additionalData' => $this->setAdditionalData($stpOperationType, $transaction)
            ];
        }
        return Transactions::fromStp($transactionsData, $transactionType, $statusId);
    }

    public function setAdditionalData(string $stpOperationType, array $transaction): array
    {
        return [
            'stpOperationType' => $stpOperationType,
            'stpAccountId' => $transaction['stpAccountId'],
            'stpAccountNumber' => $transaction['stpAccountNumber'],
            'sourceCompanyId' => $transaction['companyId'] ?? $transaction['sourceCompany']['companyId'],
            'sourceRfc' => $transaction['rfc'] ?? $transaction['sourceCompany']['rfc'],
            'sourceBalance' => $transaction['sourceCompany']['balance'],
            'destinationCompanyId' => $transaction['companyId'] ?? $transaction['destinationCompany']['companyId'],
            'destinationRfc' => $transaction['rfc'] ?? $transaction['destinationCompany']['rfc'],
            'destinationBankName' => $transaction['bankName'] ?? $transaction['destinationCompany']['bankName'],
            'destinationBalance' => $transaction['destinationCompany']['balance']
        ];
    }

}