<?php declare(strict_types=1);


namespace Viabo\stp\notifications\application\SendTransactionCreated;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\service\find_business\BusinessFinder;
use Viabo\stp\transaction\domain\events\StpTransactionCreatedDomainEvent;

final readonly class SendMessageExternalTransactionCreated implements DomainEventSubscriber
{
    public function __construct(
        private EmailRepository $repository,
        private BusinessFinder  $businessFinder
    )
    {
    }

    public static function subscribedTo(): array
    {
        return [StpTransactionCreatedDomainEvent::class];
    }

    public function __invoke(StpTransactionCreatedDomainEvent $event): void
    {
        $transaction = $event->toPrimitives();
        $business = $this->businessFinder->__invoke($transaction['businessId']);
        $email = $transaction['destinationEmail'];

        if ($transaction['additionalData']['isInternalTransaction']) {
            return;
        }

        if (empty($email)) {
            return;
        }

        $email = new Email(
            [$email],
            ['email' => "noreply@set.lat", 'name' => 'Notificaciones'],
            "Notificación Spei Out- Transferencia Externa",
            "stp/{$business['templateFile']}/notification/emails/spei.external.transaction.html.twig",
            [
                'transactionType' => 'Operación SPEI Deposito',
                'statusName' => $transaction['statusName'],
                'sourceAccount' => $transaction['sourceAccount'],
                'sourceName' => $transaction['sourceName'],
                'sourceRfc' => $transaction['additionalData']['sourceRfc'],
                'destinationAccount' => $transaction['destinationAccount'],
                'destinationName' => $transaction['destinationName'],
                'destinationRfc' => $transaction['additionalData']['destinationRfc'],
                'destinationBankName' => $transaction['additionalData']['destinationBankName'],
                'amount' => $transaction['amountMoneyFormat'],
                'concept' => $transaction['concept'],
                'reference' => $transaction['trackingKey'],
                'urlCEP' => $transaction['urlCEP'],
                'date' => $transaction['createDate']
            ]
        );

        $this->repository->send($email);
    }
}