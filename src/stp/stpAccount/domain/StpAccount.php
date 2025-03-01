<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\domain;


final class StpAccount
{
    public function __construct(
        private StpAccountId             $id,
        private StpAccountBusinessId     $businessId,
        private StpAccountNumber         $number,
        private StpAccountAcronym        $acronym,
        private StpAccountCompany        $company,
        private StpAccountKey            $key,
        private StpAccountUrl            $url,
        private StpAccountPendingCharges $pendingCharges,
        private StpAccountBalance        $balance,
        private StpAccountBalanceDate    $balanceDate,
        private StpAccountActive         $active
    )
    {
    }

    public function id(): string
    {
        return $this->id->value();
    }

    public function number(): string
    {
        return $this->number->decrypt();
    }

    public function company(): string
    {
        return $this->company->value();
    }

    public function updateBalance(float $pendingCharges, float $balance): void
    {
        $this->pendingCharges = $this->pendingCharges->update($pendingCharges);
        $this->balance = $this->balance->update($balance);
        $this->balanceDate = $this->balanceDate->update();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'businessId' => $this->businessId->value(),
            'number' => $this->number->value(),
            'acronym' => $this->acronym->value(),
            'company' => $this->company->value(),
            'key' => $this->key->value(),
            'url' => $this->url->value(),
            'pendingCharges' => $this->pendingCharges->value(),
            'balance' => $this->balance->value(),
            'balanceDate' => $this->balanceDate->value(),
            'active' => $this->active->value()
        ];
    }

    public function decrypt(): array
    {
        return [
            'id' => $this->id->value(),
            'businessId' => $this->businessId->value(),
            'number' => $this->number->decrypt(),
            'acronym' => $this->acronym->value(),
            'company' => $this->company->value(),
            'key' => $this->key->decrypt(),
            'url' => $this->url->decrypt(),
            'pendingCharges' => $this->pendingCharges->value(),
            'balance' => $this->balance->value(),
            'balanceDate' => $this->balanceDate->value(),
            'active' => $this->active->value()
        ];
    }
}