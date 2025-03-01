<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\domain;


final class CostCenterCompany
{
    public function __construct(private string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public static function fromValue(array $values): static
    {
        $companyId = $values['CompanyId'] ?? $values['companyId'];
        return new static($companyId);
    }

    public function toArray(): array
    {
        return ['id' => $this->id];
    }
}