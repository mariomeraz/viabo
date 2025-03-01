<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\utils\NumberFormat;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionCommissions extends StringValueObject
{
    private static array $data = [
        'speiOut' => 0,
        'speiIn' => 0,
        'internal' => 0,
        'feeStp' => 0,
        'stpAccount' => 0,
        'total' => 0
    ];

    public static function empty(): static
    {
        return new static('');
    }

    public static function fromExternal(array $commissions, float|string $amount): static
    {
        $commissions = self::calculateExternalCommissions($commissions, $amount);
        return new static(json_encode($commissions));
    }

    public static function fromInternal(
        array        $commissions,
        float|string $amount,
        string       $sourceAccountType,
        string       $destinationAccountType
    ): static
    {
        $commissions = self::calculateInternalCommissions(
            $commissions,
            $amount,
            $sourceAccountType,
            $destinationAccountType
        );
        return new static(json_encode($commissions));
    }

    public static function fromSpeiIn(array $commissions, float|string $amount): static
    {
        $commissions = self::calculateSpeiInCommissions($commissions, $amount);
        return new static(json_encode($commissions));
    }

    public function format(float $amount): array
    {
        if (empty($this->value)) {
            self::$data['total'] = $amount;
            return self::$data;
        }
        return json_decode($this->value, true);
    }

    private static function calculateExternalCommissions(array $commissions, float|string $amount): array
    {
        self::clearData();
        if (empty($commissions)) {
            self::$data['total'] = $amount;
            return self::$data;
        }

        self::$data['speiOut'] = self::calculatePercentage($amount, $commissions['speiOut']);
        self::$data['feeStp'] = $commissions['feeStp'];
        self::$data['total'] = $amount + array_sum(self::$data);
        return self::$data;
    }

    private static function calculateInternalCommissions(
        array  $commissions,
        float  $amount,
        string $sourceAccountType = '',
        string $destinationAccountType = ''
    ): array
    {
        self::clearData();
        if (empty($commissions)) {
            self::$data['total'] = $amount;
            return self::$data;
        }

        if ($sourceAccountType === 'company' && $destinationAccountType === 'company') {
            self::$data['internal'] = self::calculatePercentage($amount, $commissions['internal']);
        }

        if ($sourceAccountType === 'company' && $destinationAccountType === 'stpAccount') {
            self::$data['stpAccount'] = self::calculatePercentage($amount, $commissions['stpAccount']);
        }

        self::$data['total'] = $amount + array_sum(self::$data);
        return self::$data;
    }

    private static function calculateSpeiInCommissions(array $commissions, float|string $amount): array
    {
        self::clearData();
        self::$data['speiIn'] = self::calculatePercentage($amount, $commissions['speiIn']);
        self::$data['total'] = $amount - array_sum(self::$data);
        return self::$data;
    }

    private static function calculatePercentage(float|string $amount, $percentage): float
    {
        return NumberFormat::float($amount * $percentage / 100);
    }

    private static function clearData(): void
    {
        self::$data = [
            'speiOut' => 0,
            'speiIn' => 0,
            'internal' => 0,
            'feeStp' => 0,
            'stpAccount' => 0,
            'total' => 0
        ];
    }

    public function toArray(): array
    {
        return empty($this->value) ? [] : json_decode($this->value, true);
    }

    public function sum(): float
    {
        $commissions = $this->toArray();
        unset($commissions['total']);
        return array_sum($commissions);
    }

    public function total(): float
    {
        $commissions = $this->toArray();
        return $commissions['total'] ?? 0;
    }

}