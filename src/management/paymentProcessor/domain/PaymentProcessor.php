<?php declare(strict_types=1);


namespace Viabo\management\paymentProcessor\domain;


final class PaymentProcessor
{
    public function __construct(
        private PaymentProcessorId     $id ,
        private PaymentProcessorName   $name ,
        private PaymentProcessorActive $active
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'active' => $this->active->value()
        ];
    }
}