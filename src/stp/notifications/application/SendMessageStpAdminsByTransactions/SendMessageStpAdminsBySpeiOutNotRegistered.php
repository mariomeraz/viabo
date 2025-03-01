<?php declare(strict_types=1);


namespace Viabo\stp\notifications\application\SendMessageStpAdminsByTransactions;


use Viabo\security\user\domain\events\StpAdminsEmailsFoundDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\service\find_business\BusinessFinder;

final readonly class SendMessageStpAdminsBySpeiOutNotRegistered implements DomainEventSubscriber
{
    public function __construct(
        private EmailRepository $repository,
        private BusinessFinder  $businessFinder
    )
    {
    }

    public static function subscribedTo(): array
    {
        return [StpAdminsEmailsFoundDomainEvent::class];
    }

    public function __invoke(StpAdminsEmailsFoundDomainEvent $event): void
    {
        $transaction = $event->toPrimitives();
        $business = $this->businessFinder->__invoke($transaction['businessId']);
        $emails = $transaction['stpAdminsEmails'];

        if (empty($emails) || $transaction['additionalData']['stpOperationType'] !== 'speiOutNotRegistered') {
            return;
        }

        $email = new Email(
            $emails,
            ['email' => "noreply@set.lat", 'name' => 'Notificaciones'],
            "Notificación SPEI OUT - No reconocida",
            "stp/{$business['templateFile']}/notification/emails/stp.transaction.spei.out.not.registered.html.twig",
            [
                'transactionType' => 'Operación SPEI Out No Reconocida',
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
                'reference' => $transaction['stpId'],
                'urlCEP' => $transaction['urlCEP'],
                'date' => $transaction['liquidationDate']
            ]
        );
        $this->repository->send($email);

    }

}