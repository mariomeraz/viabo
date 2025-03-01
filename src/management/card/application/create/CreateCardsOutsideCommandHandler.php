<?php declare(strict_types=1);


namespace Viabo\management\card\application\create;


use Viabo\management\card\domain\CardCVV;
use Viabo\management\card\domain\CardExpirationDate;
use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\card\domain\CardRecorderId;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCardsOutsideCommandHandler implements CommandHandler
{
    public function __construct(private CardCreatorOutside $creator)
    {
    }

    public function __invoke(CreateCardsOutsideCommand $command): void
    {
        $cardRecorderId = new CardRecorderId($command->cardRecorderId);

        foreach ($command->cardsInformation as $information) {
            $cardNumber = CardNumber::create($information['cardNumber']);
            $cardExpiration = CardExpirationDate::create($information['expirationDate']);
            $cardCVV = CardCVV::empty($information['cvv']);
            $cardPaymentProcessor = CardPaymentProcessorId::create($information['paymentProcessorId']);
            $cardCommerceId = new CardCommerceId('');

            ($this->creator)(
                $cardRecorderId ,
                $cardNumber ,
                $cardExpiration ,
                $cardCVV ,
                $cardPaymentProcessor ,
                $cardCommerceId,
                $information['userEmail'],
                $information['userName'],
                $information['userPassword']
            );
        }
    }
}