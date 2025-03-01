<?php declare(strict_types=1);


namespace Viabo\management\paymentProcessor\application\find;


use Viabo\management\paymentProcessor\domain\PaymentProcessor;
use Viabo\management\paymentProcessor\domain\PaymentProcessorRepository;

final readonly class PaymentProcessorsFinder
{
    public function __construct(private PaymentProcessorRepository $repository)
    {
    }

    public function __invoke(): PaymentProcessorsResponse
    {
        $paymentProcessors = $this->repository->searchAll();
        return new PaymentProcessorsResponse(array_map(function(PaymentProcessor $paymentProcess){
            return $paymentProcess->toArray();
        }, $paymentProcessors));
    }

}