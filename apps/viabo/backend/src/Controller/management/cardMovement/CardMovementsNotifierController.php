<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\cardMovement;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\find\OwnerCardsQuery;
use Viabo\management\cardMovement\application\find\AddTodayCardsMovementsQuery;
use Viabo\management\cardOperation\application\find\AddTodayCardsOperationsQuery;
use Viabo\management\credential\application\find\AddCardsCredentialsQuery;
use Viabo\management\notifications\application\SendCardsMovementsNotifications\SendCardsMovementsNotifications;
use Viabo\security\user\application\find\AddUsersEmailsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardMovementsNotifierController extends ApiController
{
    public function __invoke(): Response
    {
        try {
            $cards = $this->ask(new OwnerCardsQuery());
            $cards = $this->ask(new AddUsersEmailsQuery($cards->data));
            $cards = $this->ask(new AddCardsCredentialsQuery($cards->data));
            $cards = $this->ask(new AddTodayCardsOperationsQuery($cards->data));
            $cards = $this->ask(new AddTodayCardsMovementsQuery($cards->data));
            $this->dispatch(new SendCardsMovementsNotifications($cards->data));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}