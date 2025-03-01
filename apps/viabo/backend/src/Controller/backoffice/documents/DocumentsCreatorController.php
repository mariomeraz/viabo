<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\backoffice\documents;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\documents\application\create_documents_by_register_company\CreateDocumentsCommandByRegisterCompany;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class DocumentsCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $companyId = $request->request->get('commerceId');
            $uploadDocuments = array_merge($request->request->all(), $request->files->all());
            $this->dispatch(new CreateDocumentsCommandByRegisterCompany($companyId, $uploadDocuments));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}