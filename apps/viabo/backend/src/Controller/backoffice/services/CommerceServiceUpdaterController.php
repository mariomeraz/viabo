<?php

namespace Viabo\Backend\Controller\backoffice\services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\services\application\update\UpdateCommerceServiceCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class CommerceServiceUpdaterController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $this->dispatch(new UpdateCommerceServiceCommand(
                $data['commerceId'] ,
                $data['type'],
                $data['active']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}