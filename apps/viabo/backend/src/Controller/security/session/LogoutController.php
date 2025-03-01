<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\security\session;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\session\application\update\LogoutCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class LogoutController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $this->dispatch(new LogoutCommand($tokenData['id']));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}