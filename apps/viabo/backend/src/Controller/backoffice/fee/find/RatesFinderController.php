<?php

namespace Viabo\Backend\Controller\backoffice\fee\find;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\fee\application\find\RatesQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class RatesFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $rates = $this->ask(new RatesQuery());

            return new JsonResponse($rates->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}