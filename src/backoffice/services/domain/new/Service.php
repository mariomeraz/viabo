<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new;


use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\aggregate\AggregateRoot;

abstract class Service extends AggregateRoot
{
    public function __construct(
        protected ServiceId            $id,
        protected CompanyId            $companyId,
        protected ServiceUpdateByUser  $updateByUser,
        protected ServiceUpdateDate    $updateDate,
        protected ServiceCreatedByUser $createdByUser,
        protected ServiceCreateDate    $createDate,
        protected ServiceActive        $active
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

    public function isSameType(string $type): bool
    {
        return $this->type() === $type;
    }

}
