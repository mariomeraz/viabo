<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\fundingOrder;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Viabo\management\fundingOrder\application\find\FundingOrderLeagueDataQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class FundingOrderViewController extends ApiController
{

    public function __invoke(int $referenceNumber , Request $request , Environment $twig): Response
    {
        try {
            $fundingOrder = $this->ask(new FundingOrderLeagueDataQuery($referenceNumber));
            $html = $twig->render('management/notification/emails/funding.order.spei.html.twig' , $fundingOrder->data);
            return new Response($html);
        } catch (\DomainException) {
            $html = $twig->render('management/notification/emails/funding.order.not.exist.html.twig');
            return new Response($html);
        }
    }
}