<?php
namespace Viabo\Backend\Controller\landingPages\set;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\landingPages\prospect\application\create\CreateProspectCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class ProspectCreatorController extends APIController
{
    public function __invoke(Request $request): Response
    {
        try {
            $data = $request->toArray();
            $this->dispatch(new CreateProspectCommand(
                $data['business-type'],
                $data['name'],
                $data['lastname'],
                $data['company'],
                $data['email'],
                $data['phone'],
                $data['contact-method']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}