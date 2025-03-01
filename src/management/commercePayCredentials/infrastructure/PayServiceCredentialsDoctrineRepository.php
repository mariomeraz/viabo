<?php declare(strict_types=1);

namespace Viabo\management\commercePayCredentials\infrastructure;

use Doctrine\ORM\EntityManager;
use Viabo\management\commercePayCredentials\domain\CommercePayCredentials;
use Viabo\management\commercePayCredentials\domain\PayServiceCredentialsRepository;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class PayServiceCredentialsDoctrineRepository extends DoctrineRepository implements PayServiceCredentialsRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function searchBy(string $commerceId): CommercePayCredentials|null
    {
        return $this->repository(CommercePayCredentials::class)->findOneBy(['commerceId.value' => $commerceId]);
    }
}
