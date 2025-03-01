<?php declare(strict_types=1);


namespace Viabo\security\module\domain;


final class Module
{
    public function __construct(
        private ModuleId          $id ,
        private ModuleCategoryId  $categoryId ,
        private ModuleSubmoduleId $submoduleId ,
        private ModuleOrder       $order ,
        private ModuleName        $name ,
        private ModulePath        $path ,
        private ModuleIcon        $icon ,
        private ModuleActive      $active
    )
    {
    }
}