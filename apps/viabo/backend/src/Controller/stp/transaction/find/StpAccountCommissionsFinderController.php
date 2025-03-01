<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\transaction\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\bank\application\find_bank_by_code\BankQueryByCode;
use Viabo\stp\transaction\application\find_stp_account_commissions\StpAccountCommissionsQuery;


final readonly class StpAccountCommissionsFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $startDay = $request->query->getString('startDay');
            $endDay = $request->query->getString('endDay');

            $transactions = $this->ask(new StpAccountCommissionsQuery(
                $tokenData['businessId'],
                $startDay,
                $endDay
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