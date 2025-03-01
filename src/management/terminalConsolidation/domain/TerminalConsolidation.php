<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\domain;



use Viabo\management\shared\domain\commerce\CommerceId;

final readonly class TerminalConsolidation
{
    public function __construct(
        private TerminalConsolidationId                        $id,
        private CommerceId                                     $commerceId,
        private TerminalConsolidationSpeiCardTransactionId     $speiCardTransactionId,
        private TerminalConsolidationSpeiCardTransactionAmount $speiCardTransactionAmount,
        private TerminalConsolidationTransactionId             $transactionId,
        private TerminalConsolidationAmount                    $amount,
        private TerminalConsolidationTerminalId                $terminalId,
        private TerminalConsolidationReferenceNumber           $referenceNumber,
        private TerminalConsolidationUserId                    $userId,
        private TerminalConsolidationRegisterDate              $registerDate
    )
    {
    }

    public static function create(
        CommerceId                                     $commerceId,
        TerminalConsolidationSpeiCardTransactionId     $speiCardTransactionId,
        TerminalConsolidationSpeiCardTransactionAmount $speiCardTransactionAmount,
        TerminalConsolidationTerminalId                $terminalId,
        TerminalConsolidationUserId                    $userId,
        TerminalConsolidationReferenceNumber           $referenceNumber,
        string                                         $transactionId,
        string                                         $amount,
    ): static
    {
        return new static(
            TerminalConsolidationId::random(),
            $commerceId,
            $speiCardTransactionId,
            $speiCardTransactionAmount,
            new TerminalConsolidationTransactionId($transactionId),
            new TerminalConsolidationAmount($amount),
            $terminalId,
            $referenceNumber,
            $userId,
            TerminalConsolidationRegisterDate::todayDate()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'commerceId' => $this->commerceId->value(),
            'speiCardTransactionId' => $this->speiCardTransactionId->value(),
            'speiCardTransactionAmount' => $this->speiCardTransactionAmount->value(),
            'transactionId' => $this->transactionId->value(),
            'amount' => $this->amount->value(),
            'terminalId' => $this->terminalId->value(),
            'referenceNumber' => $this->referenceNumber->value(),
            'userId' => $this->userId->value(),
            'registerDate' => $this->registerDate->value()
        ];
    }
}
