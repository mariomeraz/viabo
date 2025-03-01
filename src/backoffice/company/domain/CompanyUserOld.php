<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


final class CompanyUserOld
{
    public function __construct(
        private string $id,
        private string $profileId,
        private string $name,
        private string $lastname,
        private string $email
    )
    {
    }

    public static function create(array $values): self
    {
        return new static(
            $values['id'],
            $values['profile'],
            $values['name'],
            $values['lastname'],
            $values['email']
        );
    }

    public static function fromValue(array $values): static
    {
        return new static(
            $values['id'],
            $values['profile'],
            $values['name'],
            $values['lastname'],
            $values['email']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'profileId' => $this->profileId,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email
        ];
    }

}