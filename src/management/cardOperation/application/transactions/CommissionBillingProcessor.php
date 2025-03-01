<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\transactions;


use Psr\Log\LoggerInterface;
use Viabo\management\card\application\find\CardInformationQuery;
use Viabo\management\card\application\find\CardQueryByNumber;
use Viabo\management\cardOperation\domain\CardOperation;
use Viabo\management\cardOperation\domain\CardOperationActive;
use Viabo\management\cardOperation\domain\CardOperationBalance;
use Viabo\management\cardOperation\domain\CardOperationConcept;
use Viabo\management\cardOperation\domain\CardOperationDescriptionPay;
use Viabo\management\cardOperation\domain\CardOperationDestination;
use Viabo\management\cardOperation\domain\CardOperationOrigin;
use Viabo\management\cardOperation\domain\CardOperationOriginMain;
use Viabo\management\cardOperation\domain\CardOperationPayEmail;
use Viabo\management\cardOperation\domain\CardOperationRepository;
use Viabo\management\cardOperation\domain\CardOperationReverseEmail;
use Viabo\management\cardOperation\domain\CardOperations;
use Viabo\management\cardOperation\domain\CardOperationTypeId;
use Viabo\management\credential\application\find\CardCredentialQuery;
use Viabo\management\shared\domain\credential\CardCredentialClientKey;
use Viabo\management\shared\domain\paymentProcessor\PaymentProcessorAdapter;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;

final class CommissionBillingProcessor
{
    public function __construct(
        private CardOperationRepository $repository ,
        private PaymentProcessorAdapter $adapter ,
        private QueryBus                $queryBus ,
        private EventBus                $bus ,
        private LoggerInterface         $commissionLogger
    )
    {
    }

    public function __invoke(
        CardOperationOrigin  $originCard ,
        CardOperationBalance $balance ,
        string               $billingId
    ): void
    {
        $card = $this->cardData($originCard);

        $operation = CardOperation::create(
            new CardOperationTypeId('3') ,
            new CardOperationOrigin($card['number']) ,
            new CardOperationOriginMain('0') ,
            new CardOperationDestination('') ,
            $balance ,
            new CardOperationConcept('Comisión por servicio SPEI entrante') ,
            new CardOperationPayEmail('') ,
            new CardOperationReverseEmail('') ,
            new CardCredentialClientKey($card['clientKey']) ,
            new CardOperationDescriptionPay('Comisión por servicio SPEI entrante') ,
            new CardOperationActive('0')
        );
        $operations = new CardOperations([$operation]);

        try {
            if ($operation->hasBalance()) {
                $this->transactionPay($operations , $billingId);
            }

            $this->repository->save($operations);
            $operation->setEventCreated();
            $this->bus->publish(...$operation->pullDomainEvents());
        } catch (\DomainException) {
        }
    }

    private function cardData(CardOperationOrigin $originCard): array
    {
        $card = $this->queryBus->ask(new CardQueryByNumber($originCard->value()));
        $cardId = $card->data['id'];
        $credential = $this->queryBus->ask(new CardCredentialQuery($cardId));
        $cardInformation = $this->queryBus->ask(new CardInformationQuery($cardId , $credential->data));
        return array_merge($card->data , $cardInformation->data , ['clientKey' => $credential->data['clientKey']]);
    }

    private function transactionPay(CardOperations $operations , string $billingId): void
    {
        try {
            $this->adapter->transactionPay($operations);
        } catch (\DomainException $exception) {
            $operation = array_map(function (CardOperation $operation) use ($billingId) {
                $operation->setEventOperationFailed($billingId);
                $this->bus->publish(...$operation->pullDomainEvents());
                return $operation->toArray();
            } , $operations->getIterator()->getArrayCopy());

            $this->commissionLogger->error(
                $exception->getMessage() ,
                ['file' => $exception->getFile() , 'data' => $operation]
            );

            throw new \DomainException($exception->getMessage() , 400);
        }
    }
}