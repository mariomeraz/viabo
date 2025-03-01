<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\fundingOrder;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\fundingOrder\application\update\CancelFundingOrderCommand;
use Viabo\security\api\application\find\ApiQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class FundingOrderCancelerController extends ApiController
{

    public function __invoke(string $fundingOrderId , Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $payCash = $this->ask(new ApiQuery('Pay_Cash'));
            $this->dispatch(new CancelFundingOrderCommand(
                $tokenData['id'] ,
                $fundingOrderId ,
                $payCash->data
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}