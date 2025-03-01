<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class ReceiptInvoice extends StringValueObject
{
    public static function create(array $invoiceData): static
    {
        $value = empty($invoiceData) ? '' : json_encode($invoiceData);
        return new static($value);
    }

    public function invoiceAmountTotal(): float
    {
        $value = $this->toArray();
        return floatval($value['total']);
    }

    public function isSameRFC(string $commerceRFC): bool
    {
        $value = $this->toArray();
        return $value['recipientRFC'] === $commerceRFC;
    }

    private function toArray(): mixed
    {
        return json_decode($this->value , true);
    }

}