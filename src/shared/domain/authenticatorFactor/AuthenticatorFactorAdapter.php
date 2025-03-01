<?php declare(strict_types=1);

namespace Viabo\shared\domain\authenticatorFactor;

interface AuthenticatorFactorAdapter
{
    public function getQRContent(string $userName): array;

    public function checkCode(string $code, string $secret, string $userName): bool;
}