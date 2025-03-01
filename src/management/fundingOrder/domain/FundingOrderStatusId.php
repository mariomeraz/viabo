<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderStatusIdEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class FundingOrderStatusId extends StringValueObject
{
    private const STATUS_LIQUIDATED = '11';
    private const STATUS_CANCELED = '9';
    private const STATUS_AWAITING = '6';
    private const STATUS_PAID = '10';

    private const STATUS_NAME = [
        self::STATUS_AWAITING => 'Pendiente' ,
        self::STATUS_CANCELED => 'Cancelada' ,
        self::STATUS_PAID => 'Pagada' ,
        self::STATUS_LIQUIDATED => 'Liquidada'
    ];

    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new FundingOrderStatusIdEmpty();
        }
    }

    public static function awaiting(): static
    {
        return new static(self::STATUS_AWAITING);
    }

    public function cancel(): static
    {
        return new static(self::STATUS_CANCELED);
    }

    public function liquidated(): static
    {
        return new static(self::STATUS_LIQUIDATED);
    }

    public function hasCancelStatus(): bool
    {
        return $this->value === self::STATUS_CANCELED;
    }

    public function name(): string
    {
        return self::STATUS_NAME[$this->value];
    }

    public function hasLiquidatedStatus(): bool
    {
        return $this->value === self::STATUS_LIQUIDATED;
    }
}