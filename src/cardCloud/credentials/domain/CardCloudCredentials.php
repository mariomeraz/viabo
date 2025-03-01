<?php declare(strict_types=1);

namespace Viabo\cardCloud\credentials\domain;

use Viabo\shared\domain\utils\Crypt;

class CardCloudCredentials
{
    public function __construct(
        private string $uuid,
        private string $businessId,
        private string $apiUrl,
        private string $user,
        private string $password,
        private string $active
    )
    {
    }

    public function apiUrl(): string
    {
        return $this->decrypt($this->apiUrl);
    }

    public function user(): string
    {
        return $this->decrypt($this->user);
    }

    public function password(): string
    {
        return $this->decrypt($this->password);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'businessId' => $this->businessId,
            'apiUrl' => $this->decrypt($this->apiUrl),
            'user' => $this->decrypt($this->user),
            'password' => $this->decrypt($this->password),
            'active' => $this->active,
        ];
    }

    private function decrypt(string $value): string
    {
        return Crypt::decrypt($value);
    }
}
