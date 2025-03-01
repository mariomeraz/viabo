<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\update;


use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\management\terminalTransaction\domain\CommercePayApiAuthCode;
use Viabo\management\terminalTransaction\domain\CommercePayApiReferenceNumber;
use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;
use Viabo\management\terminalTransaction\domain\CommercePayStatusId;
use Viabo\management\terminalTransaction\domain\exceptions\CommercePayNotExist;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CommercePayUpdater
{
    public function __construct(private TerminalTransactionRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(
        CommercePayId                 $id,
        CommercePayStatusId           $statusId,
        CommercePayApiAuthCode        $authCode,
        CommercePayApiReferenceNumber $referenceNumber
    ): void
    {
        $commercePay = $this->repository->search($id);

        if(empty($commercePay)){
            throw new CommercePayNotExist();
        }

        $commercePay->update($statusId,$authCode,$referenceNumber);
        $this->repository->update($commercePay);

        $this->bus->publish(...$commercePay->pullDomainEvents());
    }
}
