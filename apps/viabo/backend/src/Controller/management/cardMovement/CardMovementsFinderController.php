<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\cardMovement;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\find\CardQuery;
use Viabo\management\cardMovement\application\find\CardMovementsQuery;
use Viabo\management\cardOperation\application\find\CardOperationsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardMovementsFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $cardId = $request->query->getString('cardId');
            $initialDate = $request->query->getString('startDate');
            $finalDate = $request->query->getString('endDate');
            $cardData = $this->ask(new CardQuery($cardId));
            $operationData = $this->ask(new CardOperationsQuery($cardData->data['number'] , $initialDate , $finalDate));
            $movements = $this->ask(new CardMovementsQuery(
                $cardData->data ,
                $initialDate ,
                $finalDate ,
                $operationData->data
            ));

            return new JsonResponse($this->opensslEncrypt($movements->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}