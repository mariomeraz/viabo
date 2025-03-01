<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\domain;

use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayTransactionFilterTag extends StringValueObject
{
    private const  MASTER_CARD_BRAND = 'MASTER CARD';
    private const  VISA_CARD_BRAND = 'VISA';
    private const  CARNET_CARD_BRAND = 'CARNET';
    private const  AMEX_CARD_BRAND = 'AMEX';
    public  function cardBrandIs(?string $value):string
    {
        $cardBrand = "OTRO";

        if ($value === self::MASTER_CARD_BRAND) {
            $cardBrand = $value;
        }

        if ($value === self::VISA_CARD_BRAND) {
            $cardBrand = $value;
        }

        if ($value === self::AMEX_CARD_BRAND) {
            $cardBrand = $value;
        }

        if ($value === self::CARNET_CARD_BRAND) {
            $cardBrand = $value;
        }

        return $cardBrand;
    }

    public function isApproved(bool $value): string
    {
        return $value ? 'APROBADO': 'RECHAZADO';
    }
}
