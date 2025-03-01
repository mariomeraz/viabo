<?php

namespace Viabo\Backend\Controller\security\user\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\user\application\update\ResetCardOwnerPasswordCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class CardOwnerPasswordUpdaterController extends ApiController
{
    public function __invoke(string $userId , Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $this->dispatch(new ResetCardOwnerPasswordCommand($userId));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
