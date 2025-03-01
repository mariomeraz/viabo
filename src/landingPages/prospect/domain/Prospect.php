<?php declare(strict_types=1);


namespace Viabo\landingPages\prospect\domain;


use Viabo\landingPages\prospect\domain\events\ProspectCreatedDomainEvent;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class Prospect extends AggregateRoot
{
    public function __construct(
        private ProspectId            $id ,
        private ProspectBusinessType  $businessType ,
        private ProspectName          $name ,
        private ProspectLastname      $lastname ,
        private ProspectCompany       $company ,
        private ProspectEmail         $email ,
        private ProspectPhone         $phone ,
        private ProspectContactMethod $contactMethod ,
        private ProspectCreateDate    $createDate
    )
    {
    }

    public static function create(
        string $businessType ,
        string $name ,
        string $lastname ,
        string $company ,
        string $email ,
        string $phone ,
        string $contactMethod
    ): static
    {
        $prospect = new static(
            ProspectId::random() ,
            ProspectBusinessType::create($businessType) ,
            ProspectName::create($name) ,
            ProspectLastname::create($lastname) ,
            new ProspectCompany($company) ,
            ProspectEmail::create($email) ,
            new ProspectPhone($phone) ,
            ProspectContactMethod::create($contactMethod) ,
            ProspectCreateDate::todayDate()
        );
        $prospect->record(new ProspectCreatedDomainEvent($prospect->id() , $prospect->toArray()));
        return $prospect;
    }

    public function id(): string
    {
        return $this->id->value();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'businessType' => $this->businessType->value() ,
            'name' => $this->name->value() ,
            'lastname' => $this->lastname->value() ,
            'company' => $this->company->value() ,
            'email' => $this->email->value() ,
            'phone' => $this->phone->value() ,
            'contactMethod' => $this->contactMethod->value() ,
            'createDate' => $this->createDate->value()
        ];
    }
}