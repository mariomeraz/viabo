<?php

namespace Viabo\Backend\Controller\security\healthCheck;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HealthCheckController extends AbstractController
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(['response' => 'Heal check security'], Response::HTTP_CREATED);
    }
}