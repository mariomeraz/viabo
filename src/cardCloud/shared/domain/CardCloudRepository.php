<?php

namespace Viabo\cardCloud\shared\domain;

interface CardCloudRepository
{
    public function createAccount(string $businessId, string $companyId, string $rfc): array;

    public function createTransfer(string $businessId, array $transferData): array;

    public function createTransferFromFile(string $businessId, string $subAccountId, array $fileData): void;

    public function searchSubAccount(string $businessId, string $subAccountId): array;

    public function searchMovements(string $businessId, string $subAccountId, string $fromDate, string $toDate): array;

    public function searchSubAccountCards(string $businessId, string $subAccountId): array;

    public function searchCardDetails(string $businessId, string $cardId): array;

    public function searchCardMovements(string $businessId, string $cardId, string $fromDate, string $toDate): array;

    public function searchSubAccounts(string $businessId): array;

    public function searchCardSensitive(string $businessId, string $cardId): array;

    public function searchCardCVV(string $businessId, string $cardId): array;

    public function searchCardsStock(string $businessId): array;

    public function searchCardId(string $number, string $nip, string $date): array;

    public function assignCards(string $businessId, array $data): void;

    public function updateCardBlockStatus(string $businessId, string $cardId, string $blockStatus): array;
}
