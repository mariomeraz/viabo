<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class FundingOrderPayCashInstructionsUrls extends StringValueObject
{
    public static function empty(): static
    {
        return new static(json_encode([]));
    }

    public function update(array $value): static
    {
        $value = json_encode($value);
        return new static($value);
    }

    public function toArray(): array
    {
        return empty($this->value) ? [] : json_decode($this->value , true);
    }
}