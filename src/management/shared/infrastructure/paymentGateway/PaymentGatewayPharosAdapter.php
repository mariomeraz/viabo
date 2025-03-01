<?php declare(strict_types=1);

namespace Viabo\management\shared\infrastructure\paymentGateway;

use Viabo\management\commerceTerminal\domain\TerminalCommerceId;
use Viabo\management\shared\domain\paymentGateway\PaymentGatewayAdapter;
use Viabo\management\terminalTransactionLog\domain\CommercePayTransaction;

final class PaymentGatewayPharosAdapter implements PaymentGatewayAdapter
{
    private const TRANSFER_SALE = 'SALE';

    public function searchTerminalsBy(TerminalCommerceId $commerceId , string $apiKey): array
    {
        $url = "https://o3tkmwsybj.execute-api.us-west-2.amazonaws.com/v1_3/chains/merchants/{$commerceId->value()}/terminals";
        return $this->request([] , $url , $apiKey);
    }

    public function collectMoney(CommercePayTransaction $transaction): array
    {
        $commercePayData = $transaction->commercePayData();
        $data = array(
            'tran_type' => self::TRANSFER_SALE ,
            'stan' => $commercePayData['reference'] ,
            'date' => $transaction->date() ,
            'pos_environment' => 'ecommerce' ,
            'amount' => $commercePayData['amount'] ,
            'currency' => '484' ,
            'order_number' => $commercePayData['reference'] ,
            'terminal_code' => $commercePayData['terminalId'] ,
            'merchant_code' => $commercePayData['merchantId'] ,
            'source_ip' => $this->clientIp() ,
            'notify_url' => '' ,
            'cancel_url' => '' ,
            'return_url' => '' ,
            'email' => $commercePayData['email'] ,
            'phone' => $commercePayData['phone'] ,
            'language' => 'es' ,
            'Card' => $transaction->cardData()
        );

        $url = 'https://api.pharospayments.com/payments/v1/charge';
        return $this->request($data , $url , $commercePayData['apiKey']);
    }

    private function clientIp(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    public function searchTerminalTransactions(string $queryParams, string $apiKey): array
    {
        $url = "https://o3tkmwsybj.execute-api.us-west-2.amazonaws.com/v1_3/chains/transactions?$queryParams";

        return $this->request([],$url,$apiKey);
    }

    public function request(array $inputData , string $url , string $apiKey)
    {
        $headers = [
            'Accept: application/json' ,
            'Authorization: Basic fOzlSy1JUWCp71S' ,
            "X-API-Key: $apiKey"
        ];

        $curl = curl_init();
        if (!empty($inputData)) {
            curl_setopt($curl , CURLOPT_CUSTOMREQUEST , 'POST');
            curl_setopt($curl , CURLOPT_POSTFIELDS , json_encode($inputData));
            $headers[] = 'Content-Type: text/plain';
            $headers[] = 'Content-length: ' . strlen(json_encode($inputData));
        }
        curl_setopt($curl , CURLOPT_SSL_VERIFYPEER , false);
        curl_setopt($curl , CURLOPT_URL , $url);
        curl_setopt($curl , CURLOPT_HTTPHEADER , $headers);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER , true);

        $response = curl_exec($curl);
        curl_close($curl);

        if (!$response) {
            throw new \DomainException("Error de API Pharos: Invalid API" , 403);
        }

        $response = json_decode($response , true);
        if ($this->hasError($response)) {
            $message = $response['message'] ?? $response['Message'];
            throw new \DomainException("Error de API Pharos: $message" , 403);
        }

        return $response;
    }

    private function hasError(array $response): bool
    {
        return array_key_exists('code' , $response) || array_key_exists('Message' , $response);
    }


}
