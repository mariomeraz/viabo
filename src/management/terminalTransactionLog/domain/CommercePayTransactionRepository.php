<?php

namespace Viabo\management\terminalTransactionLog\domain;

interface CommercePayTransactionRepository
{
    public function save(CommercePayTransaction $transaction):void;

    public function searchBy(CommercePayTransactionId $transactionId):CommercePayTransaction;

}
