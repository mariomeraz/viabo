<?php declare(strict_types=1);


namespace Viabo\security\module\application\find;


use Viabo\security\module\domain\exceptions\UserModuleEmpty;
use Viabo\security\module\domain\ModulePermission;
use Viabo\security\module\domain\ModuleRepository;
use Viabo\security\module\domain\Modules;

final readonly class UserModulesFinder
{
    public function __construct(private ModuleRepository $repository)
    {
    }

    public function __invoke(array $userPermissions, array $companyServices ): UserModelsResponse
    {
        $modules = $this->repository->searchBy(new ModulePermission($userPermissions['permissionModules']));

        if (empty($modules)) {
            throw new UserModuleEmpty();
        }

        $modules = new Modules($modules);
        $modules->filterModulesByServices($companyServices);
        $modules->formatDataToArray();

        $userModules = array_merge(
            ['menu' => $modules->toArray()] ,
            ['userActions' => $userPermissions['actionsModules']]
        );
        return new UserModelsResponse($userModules);
    }
}
