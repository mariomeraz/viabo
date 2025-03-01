<?php

namespace Viabo\Backend\Controller\security\authenticatorFactor\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\authenticatorFactor\application\find\GoogleAuthenticatorQRQuery;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class GoogleAuthenticatorQRCreatorController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData  =$this->decode($request->headers->get('Authorization'));
            $qr = $this->ask(new GoogleAuthenticatorQRQuery($tokenData['name']));

            return new JsonResponse($this->opensslEncrypt($qr->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}