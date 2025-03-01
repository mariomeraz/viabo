<?php declare(strict_types=1);

namespace Viabo\management\card\domain;

final readonly class CardInformationView
{
    public function __construct(
        private string $id ,
        private string $commerceId ,
        private string $main ,
        private string $cardNumber ,
        private string $cardSpei ,
        private string $cardId ,
        private string $userId ,
        private string $userName ,
        private string $password ,
        private string $clientKey ,
        private string $paymentProcessorId ,
        private string $paymentProcessor ,
        private string $active
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id ,
            'commerceId' => $this->commerceId ,
            'main' => $this->main ,
            'number' => $this->cardNumber ,
            'cardSpei' => $this->cardSpei ,
            'cardId' => $this->cardId ,
            'userId' => $this->userId ,
            'userName' => $this->userName ,
            'password' => $this->password ,
            'clientKey' => $this->clientKey ,
            'paymentProcessorId' => $this->paymentProcessorId ,
            'paymentProcessor' => $this->paymentProcessor ,
            'active' => $this->active
        ];
    }
}
