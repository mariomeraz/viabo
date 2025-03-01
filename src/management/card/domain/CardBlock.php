<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\management\card\domain\exceptions\CardBlockInvalid;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardBlock extends StringValueObject
{
    private const CARD_BLOCK_STATUS = ['unblocked' => 'UnBlock' , 'blocked' => 'Block'];

    public static function create(string $value): self
    {
        self::validate($value);
        return new self(self::CARD_BLOCK_STATUS[$value]);
    }

    public static function validate(string $value): void
    {

        if (empty($value)) {
            throw new CardBlockInvalid();
        }

        if (!array_key_exists($value , self::CARD_BLOCK_STATUS)) {
            throw new CardBlockInvalid();
        }
    }

    public static function empty(): static
    {
        return new static(self::CARD_BLOCK_STATUS['unblocked']);
    }

    public function update(mixed $value): static
    {
        $value = empty($value) ? $this->value : strval($value);
        return new static($value);
    }

}
