<?php declare(strict_types=1);

namespace Viabo\management\commercePayCredentials\domain;

use Viabo\management\commerceTerminal\domain\TerminalMerchantId;

final readonly class CommercePayCredentials
{
    private function __construct(
        private CommercePayCredentialsId         $id ,
        private CommercePayCredentialsCommerceId $commerceId ,
        private CommercePayCredentialsApiKey     $apiKey ,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'commerceId' => $this->commerceId->value() ,
            'apiKey' => $this->apiKey->valueDecrypt() ,
        ];
    }
}
