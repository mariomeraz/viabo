<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;
use Viabo\tickets\supportReason\domain\events\SupportReasonCreatedDomainEvent;

final class SupportReason extends AggregateRoot
{
    public function __construct(
        private SupportReasonId                 $id ,
        private SupportReasonName               $name ,
        private SupportReasonDescription        $description ,
        private SupportReasonApplicantProfileId $applicantProfileId ,
        private SupportReasonAssignedProfileId  $assignedProfileId ,
        private SupportReasonColor              $color ,
        private SupportReasonCreatedByUser      $createdByUser ,
        private SupportReasonRegisterDate       $registerDate ,
        private SupportReasonActive             $active
    )
    {
    }

    public static function create(
        string $userId ,
        string $name ,
        string $description ,
        string $applicantProfileId ,
        string $assignedProfileId ,
        string $color
    ): static
    {
        $supportReason = new static(
            SupportReasonId::random() ,
            SupportReasonName::create($name) ,
            new SupportReasonDescription($description) ,
            SupportReasonApplicantProfileId::create($applicantProfileId) ,
            SupportReasonAssignedProfileId::create($assignedProfileId) ,
            new SupportReasonColor($color) ,
            new SupportReasonCreatedByUser($userId) ,
            SupportReasonRegisterDate::todayDate() ,
            SupportReasonActive::enable()
        );
        $supportReason->record(new SupportReasonCreatedDomainEvent($supportReason->id() , $supportReason->toArray()));

        return $supportReason;
    }

    public function id(): ?string
    {
        return $this->id->value();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'name' => $this->name->value() ,
            'description' => $this->description->value() ,
            'applicantProfileId' => $this->applicantProfileId->value() ,
            'assignedProfileId' => $this->assignedProfileId->value() ,
            'color' => $this->color->value() ,
            'createdByUser' => $this->createdByUser->value() ,
            'registerDate' => $this->registerDate->value() ,
            'active' => $this->active->value()
        ];
    }
}