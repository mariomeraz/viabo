<?php declare(strict_types=1);

namespace Viabo\cardCloud\shared\infrastructure;

use Doctrine\ORM\EntityManager;
use Viabo\cardCloud\credentials\domain\CardCloudCredentials;
use Viabo\cardCloud\shared\domain\CardCloudRepository;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class CardCloudApiRepository extends DoctrineRepository implements CardCloudRepository
{
    public function __construct(EntityManager $CardCloudEntityManager)
    {
        parent::__construct($CardCloudEntityManager);
    }

    public function createAccount(string $businessId, string $companyId, string $rfc): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/subaccounts");
        return $this->request($url, $token, 'POST', ["ExternalId" => $companyId, "Description" => $rfc]);
    }

    public function createTransfer(string $businessId, array $transferData): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/transfer");
        return $this->request($url, $token, 'POST', $transferData);
    }

    public function createTransferFromFile(string $businessId, string $subAccountId, array $fileData): void
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/subaccounts/$subAccountId/fund");
        $this->request($url, $token, 'POST', $fileData);
    }

    public function searchSubAccount(string $businessId, string $subAccountId): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/subaccounts/$subAccountId");
        return $this->request($url, $token, 'GET');
    }

    public function searchMovements(string $businessId, string $subAccountId, string $fromDate, string $toDate): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/subaccounts/$subAccountId/movements");
        return $this->request($url, $token, 'GET', ['from' => $fromDate, 'to' => $toDate]);
    }

    public function searchSubAccountCards(string $businessId, string $subAccountId): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/subaccounts/$subAccountId/cards");
        return $this->request($url, $token, 'GET');
    }

    public function searchCardDetails(string $businessId, string $cardId): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/card/$cardId");
        return $this->request($url, $token, 'GET');
    }

    public function searchCardMovements(string $businessId, string $cardId, string $fromDate, string $toDate): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/card/$cardId/movements");
        return $this->request($url, $token, 'GET', ['from' => $fromDate, 'to' => $toDate]);
    }

    public function searchSubAccounts(string $businessId): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/subaccounts");
        return $this->request($url, $token, 'GET');
    }

    public function searchCardSensitive(string $businessId, string $cardId): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/card/$cardId/sensitive");
        return $this->request($url, $token, 'GET');
    }

    public function searchCardCVV(string $businessId, string $cardId): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/card/$cardId/cvv");
        return $this->request($url, $token, 'GET');
    }

    public function searchCardsStock(string $businessId): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, '/v1/account/cards');
        return $this->request($url, $token, 'GET');
    }

    public function searchCardId(string $number, string $nip, string $date): array
    {
        $filters = ['card' => $number, 'pin' => $nip, 'moye' => $date];
        return $this->request("{$_ENV['CARD_CLOUD_API']}/card/validate", '', 'POST', $filters);
    }

    public function assignCards(string $businessId, array $data): void
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/account/cards/assign");
        $this->request($url, $token, 'POST', $data);
    }

    public function updateCardBlockStatus(string $businessId, string $cardId, string $blockStatus): array
    {
        list($token, $url) = $this->getUrlAndToken($businessId, "/v1/card/$cardId/$blockStatus");
        return $this->request($url, $token, 'POST');
    }

    public function getUrlAndToken(string $businessId, string $url): array
    {
        $credentials = $this->searchCredentials($businessId);
        $signResponse = $this->signIn($credentials->toArray());
        return [$signResponse['access_token'], $credentials->apiUrl() . $url];
    }

    private function searchCredentials(string $businessId): CardCloudCredentials
    {
        return $this->repository(CardCloudCredentials::class)->findOneBy(['businessId' => $businessId]);
    }

    private function signIn(array $credentials): array
    {
        $data = ['email' => $credentials['user'], 'password' => $credentials['password']];
        return $this->request("{$credentials['apiUrl']}/auth/login", '', 'POST', $data);
    }

    private function request(string $url, string $token, string $method, array $inputData = []): array
    {
        $jsonData = json_encode($inputData);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData),
            "Authorization: Bearer $token"
        ]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if (empty($response)) {
            throw new \DomainException("Error de API CARD CLOUD: DOES NOT RESPOND ", 400);
        }

        $response = json_decode($response, true);
        if ($this->hasError($httpCode)) {
            $errorMessage = $this->getErrorMessage($response);
            throw new \DomainException($errorMessage, 400);
        }

        return $response;
    }

    private function hasError(int $httpCode): bool
    {
        return $httpCode !== 200;
    }

    public function getErrorMessage(array $response): string
    {
        $errorMessage = $response['error'] ?? $response['message'] ?? '';

        return match ($errorMessage) {
            "Error while decoding the token" => "Error al decodificar el token",
            "You don't have permission to access this resource" => "No tienes permiso para acceder a este recurso",
            "Error blocking card" => "Error al bloquear la tarjeta",
            "Unauthorized" => "No autorizado",
            "Card not found or you do not have permission to access it" => "Tarjeta no encontrada o no tienes 
            permiso para acceder a ella",
            "Error getting sensitive data" => "Error al obtener datos confidenciales",
            "Error getting CVV, please try again later" => "Error al obtener CVV, inténtelo de nuevo más tarde",
            "Subaccount with this ExternalId already exists" => "La subcuenta con este Id ya existe",
            "Subaccount with this Description already exists" => "La subcuenta con esta descripción ya existe",
            "Subaccount not found or you do not have permission to access it" => "Subcuenta no encontrada o no tienes permiso para acceder a ella",
            "Error creating subaccount" => "Error al crear subcuenta",
            "Error transferring funds" => "Error al transferir fondos",
            "Error assigning card" => "Error al assignar tarjeta",
            "Error funding cards" => "Error al fondear tarjetas",
            default => "Error de API CARD CLOUD: $errorMessage"
        };
    }
}
