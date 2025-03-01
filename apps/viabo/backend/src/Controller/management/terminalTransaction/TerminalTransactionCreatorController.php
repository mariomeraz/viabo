<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\terminalTransaction;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\commercePayCredentials\application\find\PayServiceCredentialsQuery;
use Viabo\management\commerceTerminal\application\find\TerminalQuery;
use Viabo\management\terminalTransaction\application\create\CreateTerminalTransactionBySlugCommand;
use Viabo\management\terminalTransaction\application\find\TerminalTransactionQuery;
use Viabo\management\terminalTransactionLog\application\create\CreateTerminalTransactionLogCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class TerminalTransactionCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $request = $this->opensslDecrypt($request->toArray());
            $terminalTransactionId = $this->generateUuid();
            $cardData = [
                'cardNumber' => $request['cardNumber'] ,
                'cardHolder' => $request['clientName'] ,
                'expMonth' => $request['expMonth'] ,
                'expYear' => $request['expYear'] ,
                'security' => $request['security']
            ];
            $terminal = $this->ask(new TerminalQuery($request['terminalId']));
            $commercePayCredentials = $this->ask(new PayServiceCredentialsQuery($request['commerceId']));
            $this->dispatch(new CreateTerminalTransactionBySlugCommand(
                $terminalTransactionId ,
                $request['commerceId'] ,
                $request['terminalId'] ,
                $request['clientName'] ,
                $request['email'] ,
                $request['phone'] ,
                $request['description'] ,
                $request['amount']
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
