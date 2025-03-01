<?php declare(strict_types=1);


namespace Viabo\security\module\domain;


interface ModuleRepository
{
    public function searchBy(ModulePermission $userPermissions): array;
}