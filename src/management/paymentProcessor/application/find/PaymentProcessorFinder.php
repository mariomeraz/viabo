<?php declare(strict_types=1);


namespace Viabo\management\paymentProcessor\application\find;


use Viabo\management\paymentProcessor\domain\exceptions\PaymentProcessorNotExist;
use Viabo\management\paymentProcessor\domain\PaymentProcessorId;
use Viabo\management\paymentProcessor\domain\PaymentProcessorRepository;

final readonly class PaymentProcessorFinder
{
    public function __construct(private PaymentProcessorRepository $repository)
    {
    }

    public function __invoke(PaymentProcessorId $paymentProcessorId): PaymentProcessorResponse
    {
        $paymentProcessor = $this->repository->search($paymentProcessorId);

        if (empty($paymentProcessor)) {
            throw new PaymentProcessorNotExist();
        }

        return new PaymentProcessorResponse($paymentProcessor->toArray());
    }
}