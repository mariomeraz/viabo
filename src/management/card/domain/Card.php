<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\management\card\domain\events\AssignedCardDomainEventInCommerce;
use Viabo\management\card\domain\events\CardBlockUpdatedDomainEvent;
use Viabo\management\card\domain\events\CardCreatedDomainEvent;
use Viabo\management\card\domain\events\CardCreatedOutsideDomainEvent;
use Viabo\management\card\domain\events\CardCVVUpdatedDomainEvent;
use Viabo\management\card\domain\events\CardOwnerUpdatedDomainEvent;
use Viabo\management\card\domain\events\CardSETDataUpdatedDomainEvent;
use Viabo\management\card\domain\events\UpdatedCardNipDomainEvent;
use Viabo\management\shared\domain\card\CardClientKey;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\management\shared\domain\card\CardId;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class Card extends AggregateRoot
{
    private CardCredentials $credentials;
    private CardBalance $balance;
    private CardBlock $block;

    public function __construct(
        private CardId                 $id ,
        private CardMain               $main ,
        private CardNumber             $number ,
        private CardCVV                $cvv ,
        private CardExpirationDate     $expirationDate ,
        private CardExpirationMonth    $expirationMonth ,
        private CardExpirationYear     $expirationYear ,
        private CardPaymentProcessorId $paymentProcessorId ,
        private CardNip                $nip ,
        private CardSpei               $spei ,
        private CardPaynet             $paynet ,
        private CardStatusId           $statusId ,
        private CardCommerceId         $commerceId ,
        private CardOwnerId            $ownerId ,
        private CardRecorderId         $recorderId ,
        private CardAssignmentDate     $assignmentDate ,
        private CardRegisterDate       $registerDate ,
        private CardActive             $active
    )
    {
        $this->credentials = CardCredentials::empty();
        $this->balance = new CardBalance('');
        $this->block = new CardBlock('');
    }

    public static function create(
        CardRecorderId         $cardRecorderId ,
        CardNumber             $cardNumber ,
        CardExpirationDate     $cardExpirationDate ,
        CardCVV                $cardCVV ,
        CardPaymentProcessorId $paymentProcessorId ,
        CardCommerceId         $cardCommerceId
    ): static
    {
        $card = new self(
            CardId::random() ,
            new CardMain('0') ,
            $cardNumber ,
            $cardCVV ,
            $cardExpirationDate ,
            new CardExpirationMonth($cardExpirationDate->month()) ,
            new CardExpirationYear($cardExpirationDate->year()) ,
            $paymentProcessorId ,
            new CardNip('') ,
            new CardSpei('') ,
            new CardPaynet('') ,
            new CardStatusId('4') ,
            $cardCommerceId ,
            new CardOwnerId('') ,
            $cardRecorderId ,
            CardAssignmentDate::empty(),
            CardRegisterDate::todayDate() ,
            new CardActive('1')
        );

        $card->record(new CardCreatedDomainEvent($card->id()->value() , $card->toArray()));

        return $card;
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function number(): CardNumber
    {
        return $this->number;
    }

    public function block(): CardBlock
    {
        return $this->block;
    }

    public function expirationDate(): CardExpirationDate
    {
        return $this->expirationDate;
    }

    public function cvv(): CardCVV
    {
        return $this->cvv;
    }

    public function assignIn(CardCommerceId $commerceId): void
    {
        $this->commerceId = $this->commerceId->update($commerceId->value());

        $this->record(new AssignedCardDomainEventInCommerce($this->id->value() , $this->toArray()));
    }

    public function assignTo(CardOwnerId $ownerId): void
    {
        $this->ownerId = $this->ownerId->update($ownerId->value());
    }

    public function registerCredentials(CardClientKey $clientKey , CardUser $user , CardPassword $password): void
    {
        $this->credentials = CardCredentials::create($clientKey , $user , $password);
    }

    public function credentials(): CardCredentials
    {
        return $this->credentials;
    }

    public function lastDigits(): string
    {
        return $this->number->last8Digits();
    }

    public function updateSETData(array $data): void
    {
        $this->setBalance();
        $this->setBlock();

        $this->nip = $this->nip->update($data['nip'] ?? '');
        $this->spei = $this->spei->update($data['Spai'] ?? '');
        $this->paynet = $this->paynet->update($data['Paynet'] ?? '');
        $this->balance = $this->balance->update($data['Balance'] ?? '');
        $this->block = $this->block->update($data['Status'] ?? '');
        $this->record(new CardSETDataUpdatedDomainEvent($this->id->value() , $this->toArray()));
    }

    public function updateBlock(CardBlock $blockStatus): void
    {
        $this->block = $blockStatus;
        $this->record(new CardBlockUpdatedDomainEvent($this->id->value() , $this->toArray()));
    }

    public function isEmptyCVV(): bool
    {
        return $this->cvv->isEmpty();
    }

    public function updateCVV(CardCVV $cvv): void
    {
        $this->cvv = $cvv;
        $this->record(new CardCVVUpdatedDomainEvent($this->id->value() , $this->toArray()));
    }

    public function updateNip(mixed $newNip): void
    {
        $this->nip = $this->nip->update($newNip ?? '');
        $this->record(new UpdatedCardNipDomainEvent($this->id->value() , $this->toArray()));
    }

    public function hasDifferentData(CardCVV $cvv , CardExpirationDate $expiration): bool
    {
        return $this->cvv->isDifferent($cvv->valueDecrypt()) || $this->expirationDate->isDifferent($expiration->value());
    }

    public function paymentProcessorId(): CardPaymentProcessorId
    {
        return $this->paymentProcessorId;
    }

    private function updateBalance(mixed $value): CardBalance
    {
        return $this->balance->update($value);
    }

    public function updateOwner(CardOwnerId $ownerId , CardStatusId $statusId): void
    {
        $this->ownerId = $ownerId;
        $this->statusId = $statusId;
        $this->assignmentDate = CardAssignmentDate::todayDate();
        $this->record(new CardOwnerUpdatedDomainEvent($this->id->value() , $this->toArray()));
    }

    public function hasOwner(): bool
    {
        return $this->ownerId->isNotEmpty();
    }

    public function setEventCreatedOutside(string $userEmail , string $userName , string $userPassword): void
    {
        $this->record(new CardCreatedOutsideDomainEvent(
            $this->id->value() ,
            ['userEmail' => $userEmail , 'userName' => $userName , 'userPassword' => $userPassword]
        ));
    }

    public function toArray(): array
    {
        $this->setBalance();
        $this->setBlock();

        return [
            'id' => $this->id->value() ,
            'main' => $this->main->value() ,
            'number' => $this->number->value() ,
            'CVV' => $this->cvv->valueDecrypt() ,
            'expirationDate' => $this->expirationDate->value() ,
            'expirationMonth' => $this->expirationMonth->value() ,
            'expirationYear' => $this->expirationYear->value() ,
            'paymentProcessorId' => $this->paymentProcessorId->value() ,
            'nip' => $this->nip->valueDecrypt() ,
            'spei' => $this->spei->value() ,
            'paynet' => $this->paynet->value() ,
            'balance' => $this->balance->value() ,
            'block' => $this->block->value() ,
            'statusId' => $this->statusId->value() ,
            'commerceId' => $this->commerceId->value() ,
            'ownerId' => $this->ownerId->value() ,
            'recorderId' => $this->recorderId->value() ,
            'assignmentDate' => $this->assignmentDate->value() ,
            'register' => $this->registerDate->value() ,
            'active' => $this->active->value()
        ];
    }

    private function setBalance(): void
    {
        $this->balance = $this->balance ?? new CardBalance('');
    }

    private function setBlock(): void
    {
        $this->block = $this->block ?? new CardBlock('');
    }
}
