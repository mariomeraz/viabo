<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\cardOperation;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\card\application\find\CardsQueryByPaymentProcessor;
use Viabo\management\cardOperation\application\find\BalanceInTransactionQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardTransactionsFinderOnCommerceController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $paymentProcessorId = $request->get('paymentProcessorId');
            $company = $this->ask(new CompanyQueryByUser(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            $cards = $this->ask(new CardsQueryByPaymentProcessor($company->data['id'], $paymentProcessorId));
            $balanceInTransaction = $this->ask(new BalanceInTransactionQuery($cards->data));

            return new JsonResponse($balanceInTransaction->total);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}