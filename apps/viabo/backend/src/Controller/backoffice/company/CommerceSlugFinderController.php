<?php

namespace Viabo\Backend\Controller\backoffice\company;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\find\CommerceQueryBySlug;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommerceSlugFinderController extends ApiController
{

    public function __invoke(string $slug , Request $request): Response
    {
        try {
            $commerce = $this->ask(new CommerceQueryBySlug($slug));

            return new JsonResponse($this->opensslEncrypt($commerce->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }

}