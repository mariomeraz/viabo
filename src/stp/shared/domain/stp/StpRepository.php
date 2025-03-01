<?php declare(strict_types=1);


namespace Viabo\stp\shared\domain\stp;


interface StpRepository
{
    public function searchBalance(array $stpAccount): array;

    public function searchSpeiIn(array $stpAccount, string $date): array;

    public function speiOut(array $stpAccount): array;

    public function processPayment(array $stpAccount, array $transactionData): array;

}