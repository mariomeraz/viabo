<?php declare(strict_types=1);


namespace Viabo\management\paymentProcessor\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class PaymentProcessorResponse implements Response
{
    public function __construct(public array $paymentProcessor)
    {
    }
}