<?php

namespace Viabo\Backend\Controller\backoffice\company;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\update\UpdateCommerceCommandByBackoffice;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class CommerceUpdaterByBackofficeController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $files = $request->files->all();
            $this->dispatch(new UpdateCommerceCommandByBackoffice(
                $tokenData['id'] ,
                $request->request->getString('commerceId') ,
                $request->request->getString('tradeName') ,
                $request->request->getString('fiscalName') ,
                $request->request->getString('rfc') ,
                $request->request->getString('fiscalPersonType') ,
                $request->request->getString('employees') ,
                $request->request->getString('branchOffices') ,
                $request->request->getString('postalAddress') ,
                $request->request->getString('phoneNumbers') ,
                $request->request->getString('slug') ,
                $request->request->getString('publicTerminal') ,
                $files
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}