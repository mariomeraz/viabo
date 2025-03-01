<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\cardMovement;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\find\AddCommerceLegalRepresentativeQuery;
use Viabo\management\card\application\find\CardsMastersQuery;
use Viabo\management\cardMovement\application\find\AddTodayCardsMovementsQuery;
use Viabo\management\cardOperation\application\find\AddTodayCardsOperationsQuery;
use Viabo\management\credential\application\find\AddCardsCredentialsQuery;
use Viabo\management\notifications\application\SendMastersCardsMovementsNotifications\SendMastersCardsMovementsNotifications;
use Viabo\security\user\application\find\AddUsersEmailsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardsMastersMovementsNotifierController extends ApiController
{
    public function __invoke(): Response
    {
        try {
            $cards = $this->ask(new CardsMastersQuery());
            $cards = $this->ask(new AddCommerceLegalRepresentativeQuery($cards->data));
            $cards = $this->ask(new AddUsersEmailsQuery($cards->data));
            $cards = $this->ask(new AddCardsCredentialsQuery($cards->data));
            $cards = $this->ask(new AddTodayCardsOperationsQuery($cards->data));
            $cards = $this->ask(new AddTodayCardsMovementsQuery($cards->data));
            $this->dispatch(new SendMastersCardsMovementsNotifications($cards->data));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}