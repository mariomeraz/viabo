<?php declare(strict_types=1);


namespace Viabo\security\module\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\security\module\domain\ModulePermission;
use Viabo\security\module\domain\ModuleRepository;
use Viabo\security\module\domain\ModuleView;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class ModuleDoctrineRepository extends DoctrineRepository implements ModuleRepository
{
    public function __construct(EntityManager $SecurityEntityManager)
    {
        parent::__construct($SecurityEntityManager);
    }

    public function searchBy(ModulePermission $userPermissions): array
    {
        $permissions = $userPermissions->toArray();
        return $this->repository(ModuleView::class)->findBy(['id' => $permissions , 'active' => '1']);
    }
}