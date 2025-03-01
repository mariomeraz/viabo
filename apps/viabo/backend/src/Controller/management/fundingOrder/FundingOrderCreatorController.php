<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\fundingOrder;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\find\CardQuery;
use Viabo\management\fundingOrder\application\create\CreateFundingOrderCommand;
use Viabo\management\fundingOrder\application\find\FundingOrderQuery;
use Viabo\security\api\application\find\ApiQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class FundingOrderCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $payCash = $this->ask(new ApiQuery('Pay_Cash'));
            $payCashInstructions = $this->ask(new ApiQuery('Pay_Cash_Instructions'));
            $card = $this->ask(new CardQuery($data['cardId']));
            $fundingOrderId = $this->generateUuid();
            $this->dispatch(new CreateFundingOrderCommand(
                $fundingOrderId ,
                $data['cardId'] ,
                $card->data['number'] ,
                $data['amount'] ,
                $data['spei'] ,
                $data['payCash'] ,
                $payCash->data ,
                $payCashInstructions->data
            ));
            $fundingOrder = $this->ask(new FundingOrderQuery($fundingOrderId));

            return new JsonResponse($this->opensslEncrypt($fundingOrder->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}