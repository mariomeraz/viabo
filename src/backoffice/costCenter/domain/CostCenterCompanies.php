<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\domain;


use Viabo\shared\domain\Collection;

final class CostCenterCompanies extends Collection
{

    public static function fromValues(array $values): static
    {
        return new static(array_map(self::CostCenterCompanyBuilder(), $values));
    }

    private static function CostCenterCompanyBuilder(): callable
    {
        return fn(array $values): CostCenterCompany => CostCenterCompany::fromValue($values);
    }

    public function elements(): array
    {
        return $this->items();
    }

    public function toArray(): array
    {
        return array_map(function (CostCenterCompany $company) {
            return $company->id();
        }, $this->items());
    }

    public function add(string $companyId): static
    {
        return new static(array_merge($this->items(), [new CostCenterCompany($companyId, '')]));
    }

    protected function type(): string
    {
        return CostCenterCompany::class;
    }
}