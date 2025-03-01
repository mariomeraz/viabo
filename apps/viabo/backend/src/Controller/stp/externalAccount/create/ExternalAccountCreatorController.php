<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\externalAccount\create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\authenticatorFactor\application\validation\ValidateGoogleAuthenticatorCommand;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\externalAccount\application\create\CreateExternalAccountCommand;


final readonly class ExternalAccountCreatorController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $this->dispatch(new ValidateGoogleAuthenticatorCommand(
                $tokenData['id'],
                $tokenData['name'],
                $data['googleAuthenticatorCode']
            ));
            $this->dispatch(new CreateExternalAccountCommand(
                $tokenData['id'],
                $data['interbankCLABE'],
                $data['beneficiary'],
                $data['rfc'],
                $data['alias'],
                $data['bankId'],
                $data['email'],
                $data['phone']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}