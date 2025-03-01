<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\application\create;

use Viabo\management\shared\domain\commerce\CommerceId;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationSpeiCardTransactionAmount;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationSpeiCardTransactionId;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationTerminalId;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationUserId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreatorTerminalConsolidationCommandHandler implements CommandHandler
{
    public function __construct(private CreateTerminalConsolidation $creator)
    {
    }

    public function __invoke(CreatorTerminalConsolidationCommand $command):void
    {
        $commerceId = new CommerceId($command->commerceId);
        $userId = new TerminalConsolidationUserId($command->userId);
        $terminalId = new TerminalConsolidationTerminalId($command->terminalId);
        $speiCardTransactionId = new TerminalConsolidationSpeiCardTransactionId($command->speiCardTransactionId);
        $speiCardTransactionAmount = new TerminalConsolidationSpeiCardTransactionAmount($command->speiCardTransactionAmount);

         $this->creator->__invoke(
             $commerceId,$userId,$terminalId,$speiCardTransactionId,$speiCardTransactionAmount, $command->transactions, $command->threshold
         );
    }
}
