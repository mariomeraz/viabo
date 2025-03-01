<?php declare(strict_types=1);


namespace Viabo\management\card\application\create;


use Viabo\management\card\domain\CardCVV;
use Viabo\management\card\domain\CardExpirationDate;
use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\card\domain\CardRecorderId;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\services\CardCreator as CardCreatorService;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CardCreator
{
    private CardCreatorService $creator;

    public function __construct(private CardRepository $repository , private EventBus $bus)
    {
        $this->creator = new CardCreatorService($repository);
    }

    public function __invoke(
        CardRecorderId         $cardRecorderId ,
        CardNumber             $cardNumber ,
        CardExpirationDate     $cardExpirationDate ,
        CardCVV                $cardCVV ,
        CardPaymentProcessorId $cardPaymentProcessorId ,
        CardCommerceId         $cardCommerceId
    ): void
    {
        $card = $this->creator->__invoke(
            $cardRecorderId ,
            $cardNumber ,
            $cardExpirationDate ,
            $cardCVV ,
            $cardPaymentProcessorId ,
            $cardCommerceId
        );

        $this->bus->publish(...$card->pullDomainEvents());
    }
}