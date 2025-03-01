<?php declare(strict_types=1);


namespace Viabo\backoffice\users\domain;


use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\backoffice\users\domain\events\CompanyUserCreatedDomainEventOnAssign;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class CompanyUser extends AggregateRoot
{
    public function __construct(
        private CompanyId             $companyId,
        private CompanyUserId         $userId,
        private CompanyUserProfileId  $profileId,
        private CompanyUserName       $name,
        private CompanyUserLastname   $lastname,
        private CompanyUserEmail      $email,
        private CompanyUserCreateDate $createDate
    )
    {
    }

    public static function create(
        string $userId,
        string $companyId,
        string $profileId,
        string $name,
        string $lastname,
        string $email,
        string $createDate,
    ): self
    {
        return new static(
            CompanyId::create($companyId),
            CompanyUserId::create($userId),
            CompanyUserProfileId::create($profileId),
            CompanyUserName::create($name),
            CompanyUserLastname::create($lastname),
            CompanyUserEmail::create($email),
            CompanyUserCreateDate::create($createDate),
        );
    }

    public function userId(): string
    {
        return $this->userId->value();
    }

    public function companyId(): string
    {
        return $this->companyId->value();
    }

    public function update(string $name,string $lastname,string $email): void
    {
        $this->name = $this->name->update($name);
        $this->lastname = $this->lastname->update($lastname);
        $this->updateEmail($email);
    }

    public function updateEmail(string $email): void
    {
        $this->email = $this->email->update($email);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->userId->value(),
            'companyId' => $this->companyId->value(),
            'profile' => $this->profileId->value(),
            'name' => $this->name->value(),
            'lastname' => $this->lastname->value(),
            'email' => $this->email->value(),
            'createDate' => $this->createDate->value()
        ];
    }

}
