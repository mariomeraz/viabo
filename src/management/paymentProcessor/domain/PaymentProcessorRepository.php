<?php declare(strict_types=1);


namespace Viabo\management\paymentProcessor\domain;


interface PaymentProcessorRepository
{
    public function search(PaymentProcessorId $paymentProcessorId): PaymentProcessor|null;

    public function searchAll(): array;
}