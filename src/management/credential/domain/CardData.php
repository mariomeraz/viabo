<?php declare(strict_types=1);


namespace Viabo\management\credential\domain;


use Viabo\management\credential\domain\exceptions\CardDataExpirationDateEmpty;
use Viabo\management\credential\domain\exceptions\CardDataNumberEmpty;
use Viabo\management\credential\domain\exceptions\CardPaymentProcessorIdEmpty;

final class CardData
{
    public function __construct(
        private string $number ,
        private string $expirationDate ,
        private string $paymentProcessorId
    )
    {
    }

    public static function create(string $number , string $expirationDate , string $paymentProcessorId): self
    {
        self::validate($number , $expirationDate , $paymentProcessorId);
        $expirationDate = str_replace('/' , '' , $expirationDate);
        return new static($number , $expirationDate , $paymentProcessorId);
    }

    public static function empty(): static
    {
        return new static('' , '' , '');
    }

    public static function validate(string $number , string $expirationDate , string $paymentProcessorId): void
    {
        if (empty($number)) {
            throw new CardDataNumberEmpty();
        }

        if (empty($expirationDate)) {
            throw new CardDataExpirationDateEmpty();
        }

        if (empty($paymentProcessorId)) {
            throw new CardPaymentProcessorIdEmpty();
        }
    }

    public function number(): string
    {
        return $this->number;
    }

    public function expirationDate(): string
    {
        return $this->expirationDate;
    }

    public function paymentProcessorId(): string
    {
        return $this->paymentProcessorId;
    }

}