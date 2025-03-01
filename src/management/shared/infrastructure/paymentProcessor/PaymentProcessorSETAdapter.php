<?php declare(strict_types=1);


namespace Viabo\management\shared\infrastructure\paymentProcessor;


use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardCredentials;
use Viabo\management\cardMovement\domain\CardMovementFilter;
use Viabo\management\cardOperation\domain\CardOperation;
use Viabo\management\cardOperation\domain\CardOperations;
use Viabo\management\credential\domain\CardCredential;
use Viabo\management\shared\domain\paymentProcessor\PaymentProcessorAdapter;

final class PaymentProcessorSETAdapter implements PaymentProcessorAdapter
{
    public function register(CardCredential $credential): void
    {
        $this->registerUser($credential);
        $clientKey = $credential->clientKey()->valueDecrypt();
        $data = [
            'inCardPlatform' => true ,
            'clientKey' => $clientKey ,
            'clientToken' => $this->token($clientKey) ,
            'idUser' => $credential->userId()->valueDecrypt() ,
            'userCard' => $credential->userName()->valueDecrypt() ,
            'binCard' => $credential->cardNumber() ,
            'moyeCard' => $credential->cardExpirationDate() ,
            'keyCompany' => $credential->companyKey() ,
        ];
        $this->request($data);
    }

    public function searchCardInformation(CardCredentials $credential): array
    {
        $clientKey = $credential->clientKey()->valueDecrypt();
        $data = [
            'inLogin' => true ,
            'clientKey' => $clientKey ,
            'clientToken' => $this->token($clientKey) ,
            'userCard' => $credential->user()->valueDecrypt() ,
            'passCard' => $credential->password()->valueDecrypt()
        ];
        return $this->request($data);
    }

    public function searchCardNip(Card $card): array
    {
        $credential = $card->credentials();
        $clientKey = $credential->clientKey()->valueDecrypt();
        $data = [
            'GetDataPanId' => true ,
            'clientKey' => $clientKey ,
            'clientToken' => $this->token($clientKey) ,
            'binCard' => $card->number()->last8Digits() ,
            'moyeCard' => $card->expirationDate()->value() ,
            'cvv' => $card->cvv()->valueDecrypt()
        ];
        return $this->request($data);
    }

    public function searchMovements(CardMovementFilter $cardMovement): array
    {
        $clientKey = $cardMovement->clientKey()->valueDecrypt();
        $data = [
            'cardMove' => true ,
            'clientKey' => $clientKey ,
            'clientToken' => $this->token($clientKey) ,
            'binCard' => $cardMovement->cardNumber()->last8Digits() ,
            'startDate' => $cardMovement->initialDate()->value() ,
            'endDate' => $cardMovement->finalDate()->value()
        ];
        try {
            return $this->request($data);
        } catch (\DomainException) {
            return [];
        }
    }

    public function searchCardBalance(Card $card): array
    {
        $credential = $card->credentials();
        $clientKey = $credential->clientKey()->valueDecrypt();
        $data = [
            'inCardBalance' => true ,
            'clientKey' => $clientKey ,
            'clientToken' => $this->token($clientKey) ,
            'binCard' => $card->number()->last8Digits()
        ];
        return $this->request($data);
    }

    public function updateBlock(Card $card): void
    {
        $credential = $card->credentials();
        $clientKey = $credential->clientKey()->valueDecrypt();
        $data = [
            'inStatus' => true ,
            'clientKey' => $clientKey ,
            'clientToken' => $this->token($clientKey) ,
            'binCard' => $card->lastDigits() ,
            'cardStatus' => $card->block()->value()
        ];
        $this->request($data);
    }

    public function transactionPay(CardOperations $operations): void
    {
        array_map(function (CardOperation $operation) {
            $clientKey = $operation->clientKey()->valueDecrypt();
            $data = [
                'applyPay' => true ,
                'clientKey' => $clientKey ,
                'clientToken' => $this->token($clientKey) ,
                'binCard' => $operation->originCard()->last8Digits() ,
                'amount' => $operation->amount()->value() ,
                'description' => $operation->descriptionPay()->value()
            ];
            $response = $this->request($data);
            $operation->updatePayData($response);
        } , $operations->getIterator()->getArrayCopy());

    }

    public function transactionReverse(CardOperations $operations): CardOperations
    {
        $clientsKeyWithInsufficientBalance = [];
        $removeOperations = [];

        foreach ($operations->operations() as $key => $operation) {
            $clientKey = $operation->clientKey()->valueDecrypt();

            if (in_array($clientKey , $clientsKeyWithInsufficientBalance)) {
                continue;
            }

            $data = [
                'reversePay' => true ,
                'clientKey' => $clientKey ,
                'clientToken' => $this->token($clientKey) ,
                'binCard' => $operation->destinationCard()->last8Digits() ,
                'amount' => $operation->amount()->value() ,
                'description' => $operation->descriptionReverse()->value()
            ];

            try {
                $response = $this->request($data);
                $operation->updateReverseData($response);
            } catch (\DomainException) {
                $removeOperations[] = $key;
                $clientsKeyWithInsufficientBalance[] = $clientKey;
            }
        }

        return $operations->remove($removeOperations);
    }

    private function registerUser(CardCredential $credential): void
    {
        $data = [
            'inRegisterPlatform' => true ,
            'clientKey' => $credential->clientKey()->valueDecrypt() ,
            'clientToken' => $this->token($credential->clientKey()->valueDecrypt()) ,
            'userCard' => $credential->userName()->valueDecrypt() ,
            'passCard' => $credential->password()->valueDecrypt() ,
            'emailCard' => $credential->email()->valueDecrypt() ,
            'customCamp' => $credential->date() ,
            'keyCompany' => $credential->companyKey()
        ];
        $response = $this->request($data);
        $credential->setUserId(strval($response['idUser']));
    }

    private function token(string $clientKey): string
    {
        $data = ['keyTrans' => true , 'clientKey' => $clientKey];
        $response = $this->request($data);
        return $response['AuthorizationCode'];
    }

    public function request(array $inputData)
    {
        $headers = ['Accept: application/json'];
        $curl = curl_init();
        curl_setopt($curl , CURLOPT_URL , $_ENV['APP_SET_URL']);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER , true);
        curl_setopt($curl , CURLOPT_CUSTOMREQUEST , 'POST');
        curl_setopt($curl , CURLOPT_HTTPHEADER , $headers);
        curl_setopt($curl , CURLOPT_SSL_VERIFYPEER , false);
        curl_setopt($curl , CURLOPT_POSTFIELDS , json_encode($inputData));
        $response = curl_exec($curl);
        curl_close($curl);

        if (empty($response)) {
            throw new \DomainException("Error de API SET: DOES NOT RESPOND " , 403);
        }

        $response = json_decode($response , true);
        if ($this->hasError($response)) {
            throw new \DomainException("Error de API SET: {$response['ErrorMessage']}" , 403);
        }

        return $response;
    }

    private function hasError(array $response): bool
    {
        return array_key_exists('ErrorMessage' , $response);
    }
}