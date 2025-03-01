<?php

namespace Viabo\Backend\Controller\security\profile\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\profile\application\find\ProfilesQuery;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class ProfilesFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $profiles = $this->ask(new ProfilesQuery());

            return new JsonResponse($profiles->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}