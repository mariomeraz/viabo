<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\backoffice\documents;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\documents\application\delete\DeleteDocumentsCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class DocumentsDeleterController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            
            $uploadDocuments = $request->files->all();
            $commerceId = $request->request->get('commerceId');
            $this->dispatch(new DeleteDocumentsCommand($commerceId , $uploadDocuments));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}