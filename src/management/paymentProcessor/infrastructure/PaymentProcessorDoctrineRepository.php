<?php declare(strict_types=1);


namespace Viabo\management\paymentProcessor\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\management\paymentProcessor\domain\PaymentProcessor;
use Viabo\management\paymentProcessor\domain\PaymentProcessorId;
use Viabo\management\paymentProcessor\domain\PaymentProcessorRepository;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class PaymentProcessorDoctrineRepository extends DoctrineRepository implements PaymentProcessorRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function search(PaymentProcessorId $paymentProcessorId): PaymentProcessor|null
    {
        return $this->repository(PaymentProcessor::class)->find($paymentProcessorId->value());
    }

    public function searchAll(): array
    {
        return $this->repository(PaymentProcessor::class)->findBy(['active.value' => '1']);
    }
}