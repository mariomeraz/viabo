<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain;


use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\aggregate\AggregateRoot;

abstract class Commission extends AggregateRoot
{

    public function __construct(
        protected CommissionId            $id,
        protected CompanyId               $companyId,
        protected CommissionUpdatedByUser $updatedByUser,
        protected CommissionUpdateDate    $updateDate,
        protected CommissionCreatedByUser $createdByUser,
        protected CommissionCreateDate    $createDate
    )
    {
    }

    abstract protected function type(): string;

    abstract public function toArray(): array;

    abstract public function update(array $data): void;

    public function id(): string
    {
        return $this->id->value();
    }
}