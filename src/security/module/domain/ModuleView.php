<?php declare(strict_types=1);


namespace Viabo\security\module\domain;


final class ModuleView
{
    private array $submodule;

    public function __construct(
        private readonly string  $id ,
        private readonly string  $categoryId ,
        private readonly string  $subModuleId ,
        private readonly string  $serviceId ,
        private readonly string  $categoryName ,
        private readonly string  $categoryOrder ,
        private readonly string  $moduleOrder ,
        private readonly string  $moduleName ,
        private readonly string  $path ,
        private readonly string  $icon ,
        private readonly ?string $moduleActions ,
        private readonly string  $active
    )
    {
    }

    public function category(): string
    {
        return $this->categoryName;
    }

    public function isSameCategory(string $category): bool
    {
        return $this->categoryName === $category;
    }

    public function belongsToASubmodule(): bool
    {
        return !empty($this->subModuleId);
    }

    public function isSameId(string $submoduleId): bool
    {
        return $this->id === $submoduleId;
    }

    public function addSubModule(array $subModule): void
    {
        unset($subModule['id'] , $subModule['subModuleId'] , $subModule['categoryName'] , $subModule['modules']);
        $this->submodule[] = $subModule;
    }

    public function hasService(array $companyServices): bool
    {
        if(empty($this->serviceId)){
            return true;
        }

        return in_array($this->serviceId, $companyServices);
    }

    public function toArray(): array
    {
        return [
            'subModuleId' => $this->subModuleId ,
            'categoryName' => $this->categoryName ,
            'moduleName' => $this->moduleName ,
            'path' => $this->path ,
            'icon' => $this->icon ,
            'moduleActions' => $this->moduleActions ,
            'modules' => $this->submodule ?? null
        ];
    }
}