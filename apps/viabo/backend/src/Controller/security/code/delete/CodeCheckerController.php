<?php

namespace Viabo\Backend\Controller\security\code\delete;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\code\application\delete\CodeCheckerCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class CodeCheckerController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $this->dispatch(new CodeCheckerCommand($tokenData['id'] , $data['verificationCode']));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}