<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\documentAuthorization;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\documentAuthorization\application\create\DocumentAuthorizeCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class DocumentAuthorizerController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $this->dispatch(new DocumentAuthorizeCommand(
                $data['documentId'],
                $tokenData['id'] ,
                $tokenData['name'] ,
                $tokenData['profileId'] ,
                $tokenData['profile']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}