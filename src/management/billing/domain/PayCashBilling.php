<?php declare(strict_types=1);


namespace Viabo\management\billing\domain;


use Viabo\management\billing\domain\events\CreatePayCashBillingDomainEvent;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class PayCashBilling extends AggregateRoot
{
    public function __construct(
        private BillingId               $id ,
        private BillingReferencePayCash $reference ,
        private BillingData             $data ,
        private BillingRegisterDate     $registerDate
    )
    {
    }

    public static function create(BillingReferencePayCash $referencePayCash , BillingData $data): static
    {
        $billing = new static(
            BillingId::random() ,
            $referencePayCash ,
            $data ,
            BillingRegisterDate::todayDate()
        );

        $billing->record(new CreatePayCashBillingDomainEvent($billing->id()->value() , $billing->toArray()));

        return $billing;
    }

    private function id(): BillingId
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'reference' => $this->reference->value() ,
            'data' => $this->data->value() ,
            'registerDate' => $this->registerDate->value()
        ];
    }
}