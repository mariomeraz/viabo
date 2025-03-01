<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\transaction\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\transaction\application\find_transactions_by_business\TransactionsQuery;


final readonly class TransactionsFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $initialDate = $request->query->getString('initialDate');
            $endDate = $request->query->getString('endDate');
            $account = $request->query->getString('account');
            $limit = $request->query->getInt('limit');
            $transactions = $this->ask(new TransactionsQuery(
                $initialDate,
                $endDate,
                $account,
                $limit
            ));

            return new JsonResponse($transactions->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}