<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\fundingOrder;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\fundingOrder\application\update\FundingOrderConciliationCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class FundingOrderConciliationUpdaterController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $this->dispatch(new FundingOrderConciliationCommand(
                $tokenData['id'] ,
                $data['fundingOrderId'] ,
                $data['conciliationNumber']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}