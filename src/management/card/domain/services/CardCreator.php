<?php declare(strict_types=1);


namespace Viabo\management\card\domain\services;


use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardCVV;
use Viabo\management\card\domain\CardExpirationDate;
use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\card\domain\CardRecorderId;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\management\shared\domain\card\CardNumber;

final readonly class CardCreator
{
    private CardValidator $validator;

    public function __construct(private CardRepository $repository)
    {
        $this->validator = new CardValidator($repository);
    }

    public function __invoke(
        CardRecorderId         $cardRecorderId ,
        CardNumber             $cardNumber ,
        CardExpirationDate     $cardExpirationDate ,
        CardCVV                $cardCVV ,
        CardPaymentProcessorId $cardPaymentProcessorId ,
        CardCommerceId         $cardCommerceId
    ): Card
    {
        $card = Card::create(
            $cardRecorderId ,
            $cardNumber ,
            $cardExpirationDate ,
            $cardCVV ,
            $cardPaymentProcessorId ,
            $cardCommerceId
        );

        $this->validator->ensureNotExist($card);

        $this->repository->save($card);

        return $card;
    }
}