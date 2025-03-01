<?php

namespace Viabo\Backend\Controller\security\user\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\code\application\delete\DeleteCodeCommand;
use Viabo\security\code\application\find\CodeVerificationCommand;
use Viabo\security\user\application\update\ResetUserPasswordCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class UserPasswordUpdaterController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $this->opensslDecrypt($request->toArray());
            $this->dispatch(new CodeVerificationCommand($tokenData['id'] , $data['code']));
            $this->dispatch(new ResetUserPasswordCommand(
                $tokenData['id'] ,
                $data['currentPassword'] ,
                $data['newPassword'] ,
                $data['confirmationPassword']
            ));
            $this->dispatch(new DeleteCodeCommand($tokenData['id'] , $data['code']));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
