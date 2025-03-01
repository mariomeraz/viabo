<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\fundingOrder;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\fundingOrder\application\find\FundingOrderQuery;
use Viabo\management\notifications\application\SendFundingOrder\SendFundingOrderCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class FundingOrderSenderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $fundingOrder = $this->ask(new FundingOrderQuery($data['fundingOrderId']));
            $this->dispatch(new SendFundingOrderCommand($fundingOrder->data , $data['emails']));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}