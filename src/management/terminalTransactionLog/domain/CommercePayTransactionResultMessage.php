<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\domain;

use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayTransactionResultMessage extends StringValueObject
{
    const RESPONSE_CODE_PHAROS = [
        '00' => 'Transacción aprobada',
        '01' => 'Contactar al emisor',
        '03' => 'Comercio inválido',
        '04' => 'Retener tarjeta',
        '05' => 'Rechazo genérico',
        '11' => 'Transacción aprobada (VIP)',
        '12' => 'Transacción inválida',
        '13' => 'Importe inválido',
        '14' => 'Número de tarjeta inválido',
        '15' => 'Emisor no reconocido',
        '30' => 'Error de formato',
        '31' => 'Banco no soportado',
        '33' => 'Tarjeta vencida',
        '34' => 'Sospecha de fraude',
        '41' => 'Tarjeta perdida',
        '43' => 'Tarjeta robada. Retener tarjeta',
        '51' => 'Fondos insuficientes',
        '54' => 'Tarjeta vencida',
        '56' => 'Tarjeta no encontrada',
        '91' => 'Emisor o procesador no operativo',
        '92' => 'Destino desconocido',
        '94' => 'Transacción duplicada',
        '96' => 'Error de sistema'
    ];

    public function message(string $value):string
    {
        return self::RESPONSE_CODE_PHAROS[$value] ?? "Movimiento desconocido ($value)";
    }


}
