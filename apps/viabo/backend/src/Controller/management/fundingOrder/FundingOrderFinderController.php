<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\fundingOrder;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\billing\application\find\BillingPayCashQuery;
use Viabo\management\fundingOrder\application\find\FundingOrderQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class FundingOrderFinderController extends ApiController
{

    public function __invoke(string $fundingOrderId , Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $fundingOrder = $this->ask(new FundingOrderQuery($fundingOrderId));
            $billingPayCash = $this->ask(new BillingPayCashQuery($fundingOrder->data['referencePayCash']));

            return new JsonResponse($this->opensslEncrypt(array_merge($fundingOrder->data , $billingPayCash->data)));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}