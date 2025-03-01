<?php declare(strict_types=1);


namespace Viabo\management\billing\domain;


use Viabo\management\billing\domain\events\BillingCreatedDomainEvent;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class Billing extends AggregateRoot
{
    public function __construct(
        private BillingId                   $id ,
        private BillingReference            $reference ,
        private BillingApiKey               $apiKey ,
        private BillingCommissionType       $commissionType ,
        private BillingCardNumber           $cardNumber ,
        private BillingCommissionPercentage $percentage ,
        private BillingAmount               $amount ,
        private BillingCommission           $commission ,
        private BillingData                 $data ,
        private BillingRegisterDate         $registerDate
    )
    {
    }

    public static function create(
        BillingApiKey               $apiKey ,
        BillingCardNumber           $cardNumber ,
        BillingCommissionType       $commissionType ,
        BillingAmount               $amount ,
        BillingCommissionPercentage $percentage ,
        BillingCommission           $commission ,
        BillingData                 $data
    ): static
    {
        $deposit = new static(
            BillingId::random() ,
            BillingReference::random() ,
            $apiKey ,
            $commissionType ,
            $cardNumber ,
            $percentage ,
            $amount ,
            $commission ,
            $data ,
            BillingRegisterDate::todayDate()
        );

        $deposit->record(new BillingCreatedDomainEvent($deposit->id()->value() , $deposit->toArray()));
        return $deposit;
    }

    public function id(): BillingId
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'reference' => $this->reference->value() ,
            'apiKey' => $this->apiKey->value() ,
            'commissionType' => $this->commissionType->value() ,
            'commissionPercentage' => $this->percentage->value() ,
            'cardNumber' => $this->cardNumber->value() ,
            'amount' => $this->amount->value() ,
            'commission' => $this->commission->valueString() ,
            'data' => $this->data->value() ,
            'registerDate' => $this->registerDate->value()
        ];
    }

    public function toArrayReference(): array
    {
        return ['reference' => $this->reference->value() , 'registerDate' => $this->registerDate->value()];
    }
}