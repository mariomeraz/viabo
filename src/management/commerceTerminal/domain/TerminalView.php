<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\domain;

final class TerminalView
{
    private bool $shared;

    public function __construct(
        private string  $id ,
        private string  $main ,
        private string  $commerceId ,
        private string  $merchantId ,
        private string  $terminalId ,
        private string  $apiData ,
        private string  $createdByUser ,
        private string  $name ,
        private string  $typeId ,
        private string  $typeName ,
        private string  $registerDate ,
        private mixed   $speiCard ,
        private ?string $cardId ,
        private bool    $isExternalConciliation ,
        private string  $active
    )
    {
        $this->shared = false;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function updateCommerceId(string $commerceId): void
    {
        $this->commerceId = $commerceId;
    }

    public function isVirtual(): bool
    {
        $virtualType = '1';
        return $this->typeId === $virtualType;
    }

    public function setShared(): void
    {
        $this->shared = true;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id ,
            'main' => $this->main ,
            'commerceId' => $this->commerceId ,
            'merchantId' => $this->merchantId ,
            'terminalId' => $this->terminalId ,
            'apiData' => $this->apiData ,
            'createdByUser' => $this->createdByUser ,
            'name' => $this->name ,
            'typeId' => $this->typeId ,
            'typeName' => $this->typeName ,
            'registerDate' => $this->registerDate ,
            'speiCard' => $this->speiCard ,
            'cardId' => $this->cardId ,
            'active' => $this->active ,
            'isConciliationExternal' => $this->isExternalConciliation,
            'shared' => $this->shared ?? false
        ];
    }
}
