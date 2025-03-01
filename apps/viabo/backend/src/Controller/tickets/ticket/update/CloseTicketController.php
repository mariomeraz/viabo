<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\tickets\ticket\update;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\tickets\ticket\application\update\CloseTicketCommand;

final readonly class CloseTicketController extends ApiController
{
    public function __invoke(int $ticketId , Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $this->dispatch(new CloseTicketCommand($tokenData['id'] , $ticketId));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}