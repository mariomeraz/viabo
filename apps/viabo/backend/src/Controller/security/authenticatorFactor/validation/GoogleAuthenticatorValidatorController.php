<?php

namespace Viabo\Backend\Controller\security\authenticatorFactor\validation;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\authenticatorFactor\application\validation\ValidateGoogleAuthenticatorCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class GoogleAuthenticatorValidatorController extends ApiController
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

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}