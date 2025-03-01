<?php

namespace Viabo\Backend\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class UtilitiesController extends ApiController
{
    public function encrypt(Request $request): Response
    {
        try {
            $data = $this->opensslEncrypt($request->toArray());

            return new JsonResponse($data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }

    public function decrypt(Request $request): Response
    {
        try {
            $data = $this->opensslDecrypt($request->toArray());

            return new JsonResponse($data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}