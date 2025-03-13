<?php

namespace Viabo\Backend\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExternalApiController extends AbstractController
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[Route('/api/external-data', name: 'external_data', methods: ['GET'])]
    public function fetchExternalData(): JsonResponse
    {
        $externalUrl = 'https://www.gamerpower.com/api/giveaways'; // Usa https en lugar de http

        try {
            $response = $this->httpClient->request('GET', $externalUrl);
            $data = $response->toArray();

            return $this->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'error' => $e->getMessage(),
                'url' => $externalUrl // Agrega la URL en la respuesta para depuración
            ], 500);
        }
    }
}