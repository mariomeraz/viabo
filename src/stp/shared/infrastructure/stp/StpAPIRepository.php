<?php declare(strict_types=1);


namespace Viabo\stp\shared\infrastructure\stp;


use Viabo\stp\shared\domain\stp\StpRepository;

final readonly class StpAPIRepository implements StpRepository
{
    public function searchBalance(array $stpAccount): array
    {
        $inputData = [
            'app' => 'getBalance',
            'keys' => $stpAccount['key'],
            'company' => $stpAccount['company'],
            'account' => $stpAccount['number']
        ];

        $response = $this->request($inputData, $stpAccount['url']);
        return $response['respuesta'];
    }

    public function searchSpeiIn(array $stpAccount, string $date): array
    {
        $inputData = [
            'app' => 'getCollectionSTP',
            'keys' => $stpAccount['key'],
            'company' => $stpAccount['company'],
            'fechaOperacion' => $date
        ];

        return $this->request($inputData, $stpAccount['url']);
    }

    public function speiOut(array $stpAccount): array
    {
        $inputData = [
            'app' => 'getConciliation',
            'keys' => $stpAccount['key'],
            'company' => $stpAccount['company']
        ];

        $response = $this->request($inputData, $stpAccount['url']);
        return $response['datos'];
    }

    public function processPayment(array $stpAccount, array $transactionData): array
    {
        $inputData = [
            'app' => 'getOrder',
            'keys' => $stpAccount['key'],
            'Monto' => $transactionData['amount'],
            'Empresa' => $stpAccount['company'],
            'TipoPago' => 1,
            'ClaveRastreo' => $transactionData['trackingKey'],
            'ConceptoPago' => $transactionData['concept'],
            'CuentaOrdenante' => $stpAccount['number'],
            'NombreOrdenante' => $stpAccount['company'],
            'RfcCurpOrdenante' => "ND",
            'CuentaBeneficiario' => $transactionData['destinationAccount'],
            'NombreBeneficiario' => $transactionData['destinationName'],
            'ReferenciaNumerica' => $transactionData['reference'],
            'InstitucionOperante' => 90646,
            'RfcCurpBeneficiario' => "ND",
            'TipoCuentaOrdenante' => 40,
            'InstitucionContraparte' => $transactionData['destinationBankCode'],
            'TipoCuentaBeneficiario' => 40
        ];
        return $this->request($inputData, $stpAccount['url']);
    }

    public function request(array $inputData, string $api)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($inputData));
        $response = curl_exec($curl);
        curl_close($curl);

        if (empty($response)) {
            throw new \DomainException("Error de API STP: DOES NOT RESPOND ", 403);
        }

        $response = json_decode($response, true);
        if ($this->hasError($response)) {
            $mensaje = $response['resultado']['descripcionError'] ?? $response['mensaje'];
            throw new \DomainException("Error de API STP: $mensaje", 403);
        }

        return $response;
    }

    private function hasError(array $response): bool
    {
        return array_key_exists('estado', $response) && $response['estado'] != '0' ||
            isset($response['resultado']['descripcionError']);
    }
}
