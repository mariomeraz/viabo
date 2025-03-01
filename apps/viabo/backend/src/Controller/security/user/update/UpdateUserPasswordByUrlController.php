<?php

namespace Viabo\Backend\Controller\security\user\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\user\application\reset_password_by_url\ResetUserPasswordCommandByUrl;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class UpdateUserPasswordByUrlController extends ApiController
{
    public function __invoke(string $userId, Request $request): Response
    {
        try {
            $this->dispatch(new ResetUserPasswordCommandByUrl($userId));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
