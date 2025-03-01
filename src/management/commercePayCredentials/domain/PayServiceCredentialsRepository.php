<?php declare(strict_types=1);

namespace Viabo\management\commercePayCredentials\domain;

interface PayServiceCredentialsRepository
{
    public function searchBy(string $commerceId): CommercePayCredentials|null;
}
