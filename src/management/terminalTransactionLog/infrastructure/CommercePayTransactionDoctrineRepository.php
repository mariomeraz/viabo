<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\infrastructure;

use Doctrine\ORM\EntityManager;
use Viabo\management\terminalTransactionLog\domain\CommercePayTransaction;
use Viabo\management\terminalTransactionLog\domain\CommercePayTransactionId;
use Viabo\management\terminalTransactionLog\domain\CommercePayTransactionRepository;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class CommercePayTransactionDoctrineRepository extends DoctrineRepository implements CommercePayTransactionRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(CommercePayTransaction $transaction): void
    {
        $this->persist($transaction);
    }

    public function searchBy(CommercePayTransactionId $transactionId): CommercePayTransaction
    {
        return $this->repository(CommercePayTransaction::class)->find($transactionId->value());

    }
}
