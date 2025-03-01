<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardMovementReceiptId extends StringValueObject
{
    private ?string $files;

    public static function empty(): static
    {
        return new static('');
    }

    public static function fromValues(string $value , ?string $files): static
    {
        $receipt = new static($value);
        $receipt->setFiles($files);
        return $receipt;
    }

    public function update(string $value): static
    {
        return new static($value);
    }

    public function isChecked(): bool
    {
        return !empty($this->value);
    }

    private function setFiles(?string $value): void
    {
        $this->files = $value;
    }

    public function files(): string
    {
        return $this->files ?? '';
    }
}