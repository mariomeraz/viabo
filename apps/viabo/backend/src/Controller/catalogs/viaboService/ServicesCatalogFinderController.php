<?php

namespace Viabo\Backend\Controller\catalogs\viaboService;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\catalogs\viaboService\application\find\FindViaboServicesQuery;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class ServicesCatalogFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $services = $this->ask(new FindViaboServicesQuery());

            return new JsonResponse($services->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}