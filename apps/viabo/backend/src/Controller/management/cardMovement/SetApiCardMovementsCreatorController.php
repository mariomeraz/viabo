<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\cardMovement;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\find\AllCardsQuery;
use Viabo\management\cardMovement\application\create\CreateCardsMovementsCommandBySetApi;
use Viabo\management\cardOperation\application\find\AllCardsOperationsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class SetApiCardMovementsCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $startDate = $request->query->getString('startDate');
            $endDate = $request->query->getString('endDate');
            $today = $request->query->getBoolean('today');
            $cards = $this->ask(new AllCardsQuery());
            $cardsOperations = $this->ask(new AllCardsOperationsQuery());
            $this->dispatch(new CreateCardsMovementsCommandBySetApi(
                $cards->data ,
                $cardsOperations->data,
                $startDate ,
                $endDate ,
                $today
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}