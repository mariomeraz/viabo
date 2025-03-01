<?php

namespace Viabo\Backend\Controller\security\code\create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\code\application\create\CreateCodeCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class CodeCreatorController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $this->dispatch(new CreateCodeCommand($tokenData['id']));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}