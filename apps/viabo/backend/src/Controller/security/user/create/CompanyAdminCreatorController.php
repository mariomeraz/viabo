<?php

namespace Viabo\Backend\Controller\security\user\create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\user\application\create_admin_by_register_company\CreateUserAdminCommandByRegisterCompany;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class CompanyAdminCreatorController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $data = $request->toArray();
            $this->dispatch(new CreateUserAdminCommandByRegisterCompany(
                $data['name'] ,
                $data['lastname'] ,
                $data['phone'] ,
                $data['email'] ,
                $data['password'] ,
                $data['confirmPassword']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}