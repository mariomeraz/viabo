<?php declare(strict_types=1);


namespace Viabo\security\module\domain;


use Viabo\shared\domain\Collection;
use Viabo\shared\domain\Utils;


final class Modules extends Collection
{

    private array $modules;

    public function filterModulesByServices(array $companyServicesTypeId): void
    {
        $this->modules = array_filter($this->items() , function (ModuleView $module) use ($companyServicesTypeId){
            return $module->hasService($companyServicesTypeId);
        });
    }

    public function formatDataToArray(): void
    {
        $categories = $this->getCategories();
        $subModules = $this->getSubmodules();
        $this->deleteSubmodules();
        $this->addSubmodules($subModules);
        $this->sortByCategories($categories);
    }

    private function getCategories(): array
    {
        return Utils::removeDuplicateElements(array_map(function (ModuleView $module) {
            return $module->category();
        } , $this->modules));
    }

    private function getSubmodules(): array
    {
        $submodules = Utils::removeDuplicateElements(array_filter($this->modules , function (ModuleView $module) {
            return $module->belongsToASubmodule();
        }));

        return array_map(function (ModuleView $module) {
            return $module->toArray();
        } , $submodules);
    }

    private function deleteSubmodules(): void
    {
        $this->modules = Utils::removeDuplicateElements(array_filter($this->modules , function (ModuleView $module) {
            return !$module->belongsToASubmodule();
        }));
    }

    private function addSubmodules(array $subModules): void
    {
        foreach ($subModules as $subModule) {
            $this->modules = array_map(function (ModuleView $module) use ($subModule) {
                if ($module->isSameId($subModule['subModuleId'])) {
                    $module->addSubModule($subModule);
                }
                return $module;
            } , $this->modules);
        }
    }

    private function sortByCategories(array $categories): void
    {
        $modules = [];
        foreach ($categories as $category) {
            $modules[] = ['category' => $category , 'modules' => $this->filterModulesBy($category)];
        }
        $this->modules = $modules;
    }

    private function filterModulesBy(string $category): array
    {
        $modules = Utils::removeDuplicateElements(array_filter($this->modules , function (ModuleView $module) use ($category) {
            return $module->isSameCategory($category);
        }));

        return array_map(function (ModuleView $module) {
            $data = $module->toArray();
            unset($data['subModuleId'] , $data['categoryName']);
            return $data;
        } , $modules);
    }

    public function toArray(): array
    {
        return $this->modules;
    }

    protected function type(): string
    {
        return ModuleView::class;
    }
}