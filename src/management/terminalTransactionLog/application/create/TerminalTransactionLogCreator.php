<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\application\create;

use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\management\shared\domain\paymentGateway\PaymentGatewayAdapter;
use Viabo\management\terminalTransactionLog\domain\CommercePayTransaction;
use Viabo\management\terminalTransactionLog\domain\CommercePayTransactionRepository;
use Viabo\management\terminalTransactionLog\domain\CommercePayTransactionTypeId;
use Viabo\management\terminalTransactionLog\domain\exceptions\CommercePayTransactionNotApproved;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class TerminalTransactionLogCreator
{
    public function __construct(
        private CommercePayTransactionRepository $repository ,
        private PaymentGatewayAdapter            $adapter ,
        private EventBus                         $bus
    )
    {
    }

    public function __invoke(
        CommercePayId                $commercePayId ,
        CommercePayTransactionTypeId $transactionTypeId,
        array                        $commercePayData ,
        array                        $cardData
    ): void
    {
        $transaction = CommercePayTransaction::create($commercePayId,$transactionTypeId);
        $transaction->setCardData($cardData);
        $transaction->setCommercePayData($commercePayData);

        $paymentGatewayData = $this->adapter->collectMoney($transaction);

        $transaction->addPaymentGateway($paymentGatewayData);
        $transaction->updateStatus();

        $this->repository->save($transaction);

        $transaction->setEventCreated();
        $this->bus->publish(...$transaction->pullDomainEvents());

        if($transaction->isNotApproved()){
            throw new CommercePayTransactionNotApproved($transaction->apiMessage()->value());
        }
    }

}
