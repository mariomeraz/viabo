<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\backoffice\credential;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\credential\application\create\CreateCredentialCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CredentialCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $data = $request->toArray();
            $this->dispatch(new CreateCredentialCommand(
                $data['commerceId'] ,
                $data['mainKey'] ,
                $data['masterCardKey'] ,
                $data['carnetKey']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}