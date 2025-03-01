<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;
use Viabo\shared\domain\utils\NumberFormat;

final class FundingOrderView extends AggregateRoot
{


    public function __construct(
        private string $id ,
        private string $referenceNumber ,
        private string $statusId ,
        private string $statusName ,
        private string $conciliation ,
        private string $cardId ,
        private string $paymentProcessorName ,
        private string $cardNumber ,
        private string $amount ,
        private string $spei ,
        private string $referencePayCash ,
        private string $instructionsUrls ,
        private string $emails ,
        private string $conciliationNumber ,
        private string $conciliationUserId ,
        private string $conciliationUserName ,
        private string $conciliationDate ,
        private string $canceledByUserId ,
        private string $canceledByUserName ,
        private string $cancellationDate ,
        private string $registerDate ,
        private string $active ,
    )
    {
    }

    private function amountFormat(): string
    {
        return NumberFormat::money(floatval($this->amount));
    }

    private function instructionsUrlsToArray(): array
    {
        return empty($this->instructionsUrls) ? [] : json_decode($this->instructionsUrls , true);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id ,
            'referenceNumber' => $this->referenceNumber ,
            'statusId' => $this->statusId ,
            'statusName' => $this->statusName ,
            'conciliated' => $this->conciliation ,
            'cardId' => $this->cardId ,
            'cardNumber' => $this->cardNumber ,
            'paymentProcessorName' => $this->paymentProcessorName ,
            'amount' => $this->amount ,
            'amountFormat' => $this->amountFormat() ,
            'spei' => $this->spei ,
            'referencePayCash' => $this->referencePayCash ,
            'instructionsUrls' => $this->instructionsUrlsToArray() ,
            'emails' => $this->emails ,
            'conciliationNumber' => $this->conciliationNumber ?? '' ,
            'conciliationUserId' => $this->conciliationUserId ?? '' ,
            'conciliationUserName' => $this->conciliationUserName ?? '' ,
            'conciliationDate' => $this->formatDate($this->conciliationDate ?? '') ,
            'canceledByUserId' => $this->canceledByUserId ?? '' ,
            'canceledByUserName' => $this->canceledByUserName ?? '' ,
            'cancellationDate' => $this->formatDate($this->cancellationDate ?? '') ,
            'registerDate' => $this->registerDate ,
            'active' => $this->active
        ];
    }

    private function formatDate(string|null $date): string
    {
        return empty($date) || $date === '0000-00-00 00:00:00' ? '' : $date;
    }

}