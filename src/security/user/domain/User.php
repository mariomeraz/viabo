<?php declare(strict_types=1);


namespace Viabo\security\user\domain;


use Viabo\security\shared\domain\user\UserEmail;
use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\events\CardOwnerDataUpdatedDomainEvent;
use Viabo\security\user\domain\events\CommerceDemoUserCreatedDomainEvent;
use Viabo\security\user\domain\events\SendUserPasswordDomainEvent;
use Viabo\security\user\domain\events\UserAdminCreatedDomainEvent;
use Viabo\security\user\domain\events\UserCreatedDomainEvent;
use Viabo\security\user\domain\events\UserDeletedDomainEvent;
use Viabo\security\user\domain\events\UserEmailUpdatedDomainEvent;
use Viabo\security\user\domain\events\UserPasswordResetDomainEvent;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    public function __construct(
        private UserId           $id,
        private UserProfile      $profile,
        private UserName         $name,
        private UserLastname     $lastname,
        private UserPhone        $phone,
        private UserEmail        $email,
        private UserPassword     $password,
        private UserStpAccountId $stpAccountId,
        private UserBusinessId   $businessId,
        private UserRegister     $register,
        private UserActive       $active
    )
    {
    }

    public static function createUserAdmin(
        string $name,
        string $lastname,
        string $phone,
        string $email,
        string $password,
        string $confirmPassword,
        string $businessId
    ): self
    {
        $user = new self(
            UserId::random(),
            UserProfile::companyAdmin(),
            UserName::create($name),
            UserLastname::create($lastname),
            UserPhone::create($phone),
            UserEmail::create($email),
            UserPassword::create($password, $confirmPassword),
            UserStpAccountId::empty(),
            UserBusinessId::create($businessId),
            UserRegister::todayDate(),
            UserActive::enable()
        );
        $user->record(new UserAdminCreatedDomainEvent($user->id()->value(), $user->toArray()));

        return $user;
    }

    public static function create(
        string $userId,
        string $profileId,
        string $name,
        string $lastname,
        string $email,
        string $phone,
        string $businessId
    ): static
    {
        $user = new self(
            new UserId($userId),
            UserProfile::create($profileId),
            UserName::create($name),
            new UserLastname($lastname),
            new UserPhone($phone),
            UserEmail::create($email),
            UserPassword::random(),
            UserStpAccountId::empty(),
            new UserBusinessId($businessId),
            UserRegister::todayDate(),
            UserActive::enable()
        );

        $user->record(new UserCreatedDomainEvent(
            $user->id()->value(), $user->toArray(), UserPassword::$passwordRandom
        ));
        return $user;
    }

    public static function demo(UserName $name, UserEmail $email, UserPhone $phone): static
    {
        $user = new static(
            UserId::random(),
            UserProfile::cardHolder(),
            $name,
            new UserLastname(''),
            $phone,
            $email,
            UserPassword::random(),
            UserStpAccountId::empty(),
            UserBusinessId::empty(),
            UserRegister::todayDate(),
            new UserActive('1'),
        );

        $user->record(new CommerceDemoUserCreatedDomainEvent($user->id()->value(), $user->toArray()));
        return $user;
    }

    public static function createCardCloudOwner(
        string $userId,
        string $profileId,
        string $name,
        string $lastname,
        string $email,
        string $phone,
        string $businessId
    ): static
    {
        $user = new self(
            new UserId($userId),
            UserProfile::create($profileId),
            UserName::create($name),
            new UserLastname($lastname),
            new UserPhone($phone),
            new UserEmail($email),
            UserPassword::random(),
            UserStpAccountId::empty(),
            new UserBusinessId($businessId),
            UserRegister::todayDate(),
            UserActive::enable()
        );

        $user->record(new UserCreatedDomainEvent(
            $user->id()->value(), $user->toArray(), UserPassword::$passwordRandom
        ));
        return $user;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email->value();
    }

    public function password(): string
    {
        return $this->password->value();
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function tokenData(): array
    {
        return ['id' => $this->id->value()];
    }

    public function isInvalidPassword(string $password): bool
    {
        return $this->password->isInvalidPassword($password);
    }

    public function isDifferent(string $passwordEntered): bool
    {
        return $this->password->isDifferent($passwordEntered);
    }

    public function isLegalRepresentative(): bool
    {
        return $this->profile->isLegalRepresentative();
    }

    public function resetPassword(): void
    {
        $this->password = $this->password->reset();
        $data = $this->toArray();
        $data['password'] = $this->password::$passwordRandom;
        $this->record(new UserPasswordResetDomainEvent($this->id->value(), $data));
    }

    public function updatePassword(string $newPassword, string $confirmationPassword): void
    {
        $this->password = UserPassword::create($newPassword, $confirmationPassword);
        $data = $this->toArray();
        $data['password'] = $this->password::$passwordRandom;
        $this->record(new UserPasswordResetDomainEvent($this->id->value(), $data));
    }

    public function update(string $name, string $lastName, string $phone): void
    {
        $this->name = $this->name->update($name);
        $this->lastname = $this->lastname->update($lastName);
        $this->phone = $this->phone->update($phone);
        $this->record(new CardOwnerDataUpdatedDomainEvent($this->id->value(), $this->toArray()));
    }

    public function updateEmail(string $email): void
    {
        $this->email = $this->email->update($email);
        $this->record(new UserEmailUpdatedDomainEvent($this->id->value(), $this->toArray()));
    }

    public function updateActive(string $active): void
    {
        $this->active = $this->active->update($active);
    }

    public function setEventSendPassword(string $cardNumber, array $legalRepresentative): void
    {
        $this->record(new SendUserPasswordDomainEvent(
            $this->id->value(),
            $this->toArray(),
            $this->password::$passwordRandom,
            $cardNumber,
            $legalRepresentative
        ));
    }

    public function setEventDeleted(): void
    {
        $this->record(new UserDeletedDomainEvent($this->id->value(), $this->toArray()));
    }

    public function isNotBusinessId(): bool
    {
        return $this->businessId->isNotDefined();
    }

    public function isNotOwnerCardCloud(): bool
    {
        return $this->profile->isNotOwnerCardCloud();
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'profile' => $this->profile->value(),
            'name' => $this->name->value(),
            'lastname' => $this->lastname->value(),
            'phone' => $this->phone->value(),
            'email' => $this->email->value(),
            'password' => $this->password->value(),
            'stpAccountId' => $this->stpAccountId->value(),
            'businessId' => $this->businessId->value(),
            'register' => $this->register->value(),
            'active' => $this->active->value()
        ];
    }
}
