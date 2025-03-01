<?php declare(strict_types=1);


namespace Viabo\stp\notifications\application\SendMessageStpAdminsByTransactions;


use Viabo\backoffice\company\domain\events\CompaniesAdminsFoundDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\service\find_business\BusinessFinder;

final readonly class SendMessageByStpSpeiOutTransactionUpdated implements DomainEventSubscriber
{
    public function __construct(
        private EmailRepository $repository,
        private BusinessFinder  $businessFinder
    )
    {
    }

    public static function subscribedTo(): array
    {
        return [CompaniesAdminsFoundDomainEvent::class];
    }

    public function __invoke(CompaniesAdminsFoundDomainEvent $event): void
    {
        $transaction = $event->toPrimitives();
        $business = $this->businessFinder->__invoke($transaction['businessId']);
        $emails = $transaction['emails'];

        if (empty($emails) || $transaction['additionalData']['stpOperationType'] !== 'speiOutUpdated') {
            return;
        }

        $email = new Email(
            $emails,
            ['email' => "noreply@set.lat", 'name' => 'Notificaciones'],
            "Notificación a Admins STP de SPEI OUT - Liquidado",
            "stp/{$business['templateFile']}/notification/emails/stp.transaction.spei.out.update.html.twig",
            [
                'transactionType' => 'Operación SPEI OUT Liquidado',
                'statusName' => $transaction['statusName'],
                'sourceAccount' => $transaction['sourceAccount'],
                'sourceName' => $transaction['sourceName'],
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