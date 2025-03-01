<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\terminalTransaction;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\commercePayCredentials\application\find\PayServiceCredentialsQuery;
use Viabo\management\commerceTerminal\application\find\TerminalQueryByPharosId;
use Viabo\management\terminalTransaction\application\create\CreateTerminalTransactionCommand;
use Viabo\management\terminalTransaction\application\find\TerminalTransactionQuery;
use Viabo\management\terminalTransactionLog\application\create\CreateTerminalTransactionLogCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommercePayVirtualTerminalCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $this->opensslDecrypt($request->toArray());
            $terminalTransactionId = $this->generateUuid();
            $cardData = [
                'cardNumber' => $data['cardNumber'] ,
                'cardHolder' => $data['clientName'] ,
                'expMonth' => $data['expMonth'] ,
                'expYear' => $data['expYear'] ,
                'security' => $data['security']
            ];
            $terminal = $this->ask(new TerminalQueryByPharosId($data['terminalId']));
            $commercePayCredentials = $this->ask(new PayServiceCredentialsQuery($data['commerceId']));
            $this->dispatch(new CreateTerminalTransactionCommand(
                $terminalTransactionId ,
                $data['commerceId'] ,
                $data['terminalId'] ,
                $data['clientName'] ,
                $data['email'] ,
                $data['phone'] ,
                $data['description'] ,
                $data['amount'] ,
                $tokenData['id']
            ));
            $terminalTransaction = $this->ask(new TerminalTransactionQuery($terminalTransactionId));
            $this->dispatch(new CreateTerminalTransactionLogCommand(
                $terminalTransaction->data ,
                $terminal->data['merchantId'] ,
                $commercePayCredentials->data['apiKey'] ,
                $cardData
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
