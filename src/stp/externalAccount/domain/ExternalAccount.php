<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;
use Viabo\stp\externalAccount\domain\events\ExternalAccountCreatedDomainEvent;
use Viabo\stp\externalAccount\domain\events\ExternalAccountDisabledDomainEvent;

final class ExternalAccount extends AggregateRoot
{
    public function __construct(
        private ExternalAccountId             $id ,
        private ExternalAccountInterbankCLABE $interbankCLABE ,
        private ExternalAccountBeneficiary    $beneficiary ,
        private ExternalAccountRfc            $rfc ,
        private ExternalAccountAlias          $alias ,
        private ExternalAccountBankId         $bankId ,
        private ExternalAccountEmail          $email ,
        private ExternalAccountPhone          $phone ,
        private ExternalAccountCreatedByUser  $createdByUser ,
        private ExternalAccountCreateDate     $createDate ,
        private ExternalAccountActive         $active
    )
    {
    }

    public static function create(
        string $userId ,
        string $interbankCLABE ,
        string $beneficiary ,
        string $rfc ,
        string $alias ,
        string $bankId ,
        string $email ,
        string $phone
    ): static
    {
        $externalAccount = new static(
            ExternalAccountId::random() ,
            ExternalAccountInterbankCLABE::create($interbankCLABE) ,
            ExternalAccountBeneficiary::create($beneficiary) ,
            new ExternalAccountRfc($rfc) ,
            new ExternalAccountAlias($alias) ,
            ExternalAccountBankId::create($bankId) ,
            new ExternalAccountEmail($email) ,
            new ExternalAccountPhone($phone) ,
            new ExternalAccountCreatedByUser($userId) ,
            ExternalAccountCreateDate::todayDate() ,
            ExternalAccountActive::enable() ,
        );

        $externalAccount->record(new ExternalAccountCreatedDomainEvent(
            $externalAccount->id() , $externalAccount->toArray()
        ));

        return $externalAccount;
    }

    public function id(): string
    {
        return $this->id->value();
    }

    public function disable(): void
    {
        $this->active = $this->active->disable();
        $this->record(new ExternalAccountDisabledDomainEvent($this->id() , $this->toArray()));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'interbankCLABE' => $this->interbankCLABE->value() ,
            'beneficiary' => $this->beneficiary->value() ,
            'rfc' => $this->rfc->value() ,
            'alias' => $this->alias->value() ,
            'bankId' => $this->bankId->value() ,
            'email' => $this->email->value() ,
            'phone' => $this->phone->value() ,
            'createdByUser' => $this->createdByUser->value() ,
            'date' => $this->createDate->value() ,
            'active' => $this->active->value()
        ];
    }
}