<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendFundingOrder;


use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;

final readonly class FundingOrderSender
{
    public function __construct(private EmailRepository $repository)
    {
    }


    public function __invoke(array $fundingOrder , array $emails): void
    {

        if (empty($emails)) {
            return;
        }

        $email = new Email(
            $emails ,
            ['email' => 'no-responder@qa.viabo.com', 'name' => 'Notificaciones'],
            "Notificación de Viabo - Orden de Fondeo" ,
            'management/notification/emails/funding.order.spei.html.twig' ,
            [
                'spei' => $fundingOrder['spei'] ,
                'amount' => $fundingOrder['amountFormat'] ,
                'referenceNumber' => $fundingOrder['referenceNumber'] ,
                'referencePayCash' => $fundingOrder['referencePayCash'] ,
                'urlPayCashFormat' => $fundingOrder['instructionsUrls']['format'] ?? '' ,
                'urlPayCashDownload' => $fundingOrder['instructionsUrls']['download'] ?? ''
            ]
        );

        $this->repository->send($email);
    }
}