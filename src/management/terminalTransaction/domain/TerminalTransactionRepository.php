<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\domain;


use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\shared\domain\criteria\Criteria;

interface TerminalTransactionRepository
{
    public function save(CommercePay $commercePay): void;

    public function search(CommercePayId $id): CommercePay|null;

    public function searchView(CommercePayId $commercePayId): CommercePayView|null;

    public function searchCriteriaView(Criteria $criteria): array;

    public function searchBy(CommercePayReference $referenceId): CommercePay|null;

    public function update(CommercePay $commercePay): void;
}
