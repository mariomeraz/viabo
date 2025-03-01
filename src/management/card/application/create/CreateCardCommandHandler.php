<?php declare(strict_types=1);


namespace Viabo\management\card\application\create;


use Viabo\management\card\domain\CardCVV;
use Viabo\management\card\domain\CardExpirationDate;
use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\card\domain\CardRecorderId;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCardCommandHandler implements CommandHandler
{
    public function __construct(private CardCreator $creator)
    {
    }

    public function __invoke(CreateCardCommand $command): void
    {
        $cardRecorderId = new CardRecorderId($command->cardRecorderId);
        $cardNumber = CardNumber::create($command->cardNumber);
        $cardExpiration = CardExpirationDate::create($command->expirationDate);
        $cardCVV = CardCVV::create($command->cvv);
        $cardPaymentProcessor = CardPaymentProcessorId::create($command->cardPaymentProcessor);
        $cardCommerceId = new CardCommerceId($command->commerceId);

        $this->creator->__invoke(
            $cardRecorderId ,
            $cardNumber ,
            $cardExpiration ,
            $cardCVV ,
            $cardPaymentProcessor ,
            $cardCommerceId
        );

    }
}