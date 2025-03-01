<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class AssignCardsCommandHandlerInCommerce implements CommandHandler
{
    public function __construct(private CardsAssignerInCommerce $assigner)
    {
    }

    public function __invoke(AssignCardsCommandInCommerce $command): void
    {
        $commerceId = CardCommerceId::create($command->commerceId);
        $paymentProcessor = CardPaymentProcessorId::create($command->paymentProcessor);

        ($this->assigner)($commerceId , $paymentProcessor , intval($command->amount));
    }
}