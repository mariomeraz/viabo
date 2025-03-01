<?php declare(strict_types=1);


namespace Viabo\management\shared\infrastructure\paymentCash;


use Viabo\management\fundingOrder\domain\FundingOrder;
use Viabo\management\shared\domain\paymentCash\PaymentCashAdapter;

final class PaymentCashPayCashAdapterAdapter implements PaymentCashAdapter
{

    public function createReference(FundingOrder $fundingOrder): string
    {
        $payCashData = $fundingOrder->payCashData();
        $data = [
            'url' => "{$payCashData['url']}/v1/reference" ,
            'method' => 'POST' ,
            'token' => $this->token($payCashData['key'] , $payCashData['url']) ,
            'fields' => [
                'Amount' => $fundingOrder->amount()->value() ,
                'ExpirationDate' => '' ,
                'Value' => $fundingOrder->payCashKey() ,
                'Type' => 'true'
            ]
        ];
        $response = $this->request($data);
        return $response['Reference'];
    }

    public function searchReference(FundingOrder $fundingOrder): array
    {
        $payCashData = $fundingOrder->payCashData();
        $reference = $fundingOrder->payCashReference();
        $data = [
            'url' => "{$payCashData['url']}/v1/search?Reference={$reference->value()}" ,
            'method' => 'GET' ,
            'token' => $this->token($payCashData['key'] , $payCashData['url'])
        ];
        $response = $this->request($data);
        if (array_key_exists('paging' , $response)) {
            return empty($response['paging']['results']) ? [] : $response['paging']['results'][0];
        }

        return [];
    }

    public function cancel(FundingOrder $fundingOrder): void
    {
        $payCashData = $fundingOrder->payCashData();
        $data = [
            'url' => "{$payCashData['url']}/v1/cancel" ,
            'method' => 'POST' ,
            'token' => $this->token($payCashData['key'] , $payCashData['url']) ,
            'fields' => [
                'Reference' => $fundingOrder->payCashReference()->value()
            ]
        ];

        $this->request($data);
    }

    private function token(string $key , string $url): string
    {
        $data = ['url' => "$url/v1/authre?key=$key" , 'method' => 'GET'];
        $response = $this->request($data);
        return $response['Authorization'];
    }

    private function request(array $data): array
    {
        $token = $data['token'] ?? '';
        $fields = $data['fields'] ?? '';

        $options = [
            CURLOPT_URL => $data['url'] ,
            CURLOPT_RETURNTRANSFER => true ,
            CURLOPT_ENCODING => '' ,
            CURLOPT_MAXREDIRS => 10 ,
            CURLOPT_TIMEOUT => 0 ,
            CURLOPT_FOLLOWLOCATION => true ,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1 ,
            CURLOPT_CUSTOMREQUEST => $data['method'] ,
            CURLOPT_POSTFIELDS => json_encode($fields) ,
            CURLOPT_HTTPHEADER => [
                "Authorization: $token" ,
                'Content-Type: application/json'
            ]
        ];

        $curl = curl_init();
        curl_setopt_array($curl , $options);
        $response = curl_exec($curl);
        curl_close($curl);

        $response = $this->format($response);
        if ($this->hasError($response)) {
            $message = $response['ErrorMessage'] ?? $response['message'];
            throw new \DomainException("Error de API PayCash: $message" , 400);
        }

        return $response;
    }

    private function format(bool|string $response): array
    {
        return is_bool($response) ? [
            'ErrorCode' => '111' ,
            'ErrorMessage' => 'Invalid API'
        ] : json_decode($response , true);
    }

    private function hasError(array $response): bool
    {
        return array_key_exists('ErrorCode' , $response) && !empty($response['ErrorCode']);
    }
}