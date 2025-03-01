<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\terminalTransaction;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\notifications\application\SendCommercePay\SendNotificationTerminalTransactionCommand;
use Viabo\management\terminalTransaction\application\create\CreateTerminalTransactionCommand;
use Viabo\management\terminalTransaction\application\find\TerminalTransactionQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommercePayCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $this->opensslDecrypt($request->toArray());
            $terminalTransactionId = $this->generateUuid();
            $this->dispatch(new CreateTerminalTransactionCommand(
                $terminalTransactionId ,
                $data['commerceId'] ,
                $data['terminalId'] ,
                $data['clientName'] ,
                $data['email'] ,
                $data['phone'] ,
                $data['description'] ,
                $data['amount'],
                $tokenData['id']
            ));
            $terminalTransaction = $this->ask(new TerminalTransactionQuery($terminalTransactionId));
            $this->dispatch(new SendNotificationTerminalTransactionCommand($terminalTransaction->data));

            return new JsonResponse(['code' => $terminalTransaction->data['urlCode']]);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
