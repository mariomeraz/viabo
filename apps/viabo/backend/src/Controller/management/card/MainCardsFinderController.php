<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\card;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\card\application\find\CardsMasterGlobalQuery;
use Viabo\management\card\application\find\CardsNumberQuery;
use Viabo\management\card\application\find\MainCardsInformationQuery;
use Viabo\management\cardOperation\application\find\BalanceMasterInTransactionQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class MainCardsFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $company = $this->ask(new CompanyQueryByUser(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            $cardsInformation = $this->ask(new MainCardsInformationQuery($company->data['id']));
            $cards = $this->ask(new CardsNumberQuery($company->data['id']));
            $masterBalanceInTransaction = $this->ask(new BalanceMasterInTransactionQuery($cards->data));
            $data = $this->ask(new CardsMasterGlobalQuery($cardsInformation->data , $masterBalanceInTransaction->data));

            return new JsonResponse($this->opensslEncrypt($data->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
