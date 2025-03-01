<?php declare(strict_types=1);


namespace Viabo\security\user\domain\events;


use Viabo\shared\domain\bus\event\DomainEvent;

final readonly class SendUserPasswordDomainEvent extends DomainEvent
{
    public function __construct(
        string         $aggregateId ,
        private array  $body ,
        private string $userPassword ,
        private string $cardNumber ,
        private array  $legaRepresentative ,
        string         $eventId = null ,
        string         $occurredOn = null
    )
    {
        parent::__construct($aggregateId , $eventId , $occurredOn);
    }

    public static function fromPrimitives(
        string $eventId ,
        string $aggregateId ,
        array  $body ,
        string $occurredOn
    ): DomainEvent
    {
        return new static($aggregateId , $body , '' , '' , [] , $eventId , $occurredOn);
    }

    public static function eventName(): string
    {
        return 'send.user.password.by.assigned.card.demo';
    }

    public function toPrimitives(): array
    {
        return $this->body;
    }

    public function password(): string
    {
        return $this->userPassword;
    }

    public function legaRepresentative(): array
    {
        return $this->legaRepresentative;
    }

    public function cardNumber(): string
    {
        return $this->cardNumber;
    }

}