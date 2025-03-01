<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\transaction\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\bank\application\find_bank_by_code\BankQueryByCode;
use Viabo\stp\transaction\application\find_statement_account\StatementAccountQuery;


final readonly class StatementAccountFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $account = $request->query->getInt('account');
            $month = $request->query->getInt('month');
            $year = $request->query->getInt('year');

            $transactions = $this->ask(new StatementAccountQuery(
                $account,
                $month,
                $year
            ));
            $transactions = $this->addBankName($transactions->data);

            return new JsonResponse($transactions);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    private function addBankName(array $transactions): array
    {
        return array_map(function (array $transaction) {
            if (!empty($transaction['destinationBankCode'])) {
                $bank = $this->ask(new BankQueryByCode($transaction['destinationBankCode']));
                $transaction['bankName'] = $bank->data['shortName'];
            }
            return $transaction;
        }, $transactions);
    }
}