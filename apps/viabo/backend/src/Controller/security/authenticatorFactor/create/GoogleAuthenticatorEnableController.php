<?php

namespace Viabo\Backend\Controller\security\authenticatorFactor\create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\authenticatorFactor\application\create\EnableGoogleAuthenticatorCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class GoogleAuthenticatorEnableController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $this->dispatch(new EnableGoogleAuthenticatorCommand(
                $tokenData['id'],
                $tokenData['name'],
                $data['secret'],
                $data['code']
            ));
            $tokenData['authenticatorFactors'] = true;
            $token = $this->encode($tokenData);

            return new JsonResponse(['token' => $token]);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}