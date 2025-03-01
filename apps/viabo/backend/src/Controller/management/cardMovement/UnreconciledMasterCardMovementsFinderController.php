<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\cardMovement;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\catalogs\threshold\application\find\FundingOrderThresholdQuery;
use Viabo\management\card\application\find\CardQuery;
use Viabo\management\cardMovement\application\find\UnreconciledMasterCardMovementsQuery;
use Viabo\management\cardOperation\application\find\CardOperationsQuery;
use Viabo\management\fundingOrder\application\find\FinishedFundingOrderQuery;
use Viabo\management\fundingOrder\application\find\FundingOrderQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class UnreconciledMasterCardMovementsFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $fundingOrderId = $request->get('fundingOrderId');
            $fundingOrder = $this->ask(new FundingOrderQuery($fundingOrderId));
            $fundingOrderAmount = $fundingOrder->data['amount'];
            $cardId = $fundingOrder->data['cardId'];
            $fundingOrderRegisterDate = $fundingOrder->data['registerDate'];
            $cardData = $this->ask(new CardQuery($cardId));
            $cardOperations = $this->ask(new CardOperationsQuery($cardData->data['number'] , $fundingOrderRegisterDate));
            $threshold = $this->ask(new FundingOrderThresholdQuery());
            $fundingOrderFinished = $this->ask(new FinishedFundingOrderQuery($cardId));
            $movements = $this->ask(new UnreconciledMasterCardMovementsQuery(
                $cardData->data ,
                $fundingOrderAmount ,
                $fundingOrderRegisterDate ,
                $threshold->data['value'] ,
                $fundingOrderFinished->data ,
                $cardOperations->data
            ));

            return new JsonResponse($this->opensslEncrypt($movements->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
