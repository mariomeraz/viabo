<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\fundingOrder;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\card\application\find\MastersCardsQueryByCommerce;
use Viabo\management\fundingOrder\application\find\FundingOrdersQueryByCards;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class FundingOrdersFinderController extends ApiController
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
            $cards = $this->ask(new MastersCardsQueryByCommerce($company->data['id']));
            $fundingOrders = $this->ask(new FundingOrdersQueryByCards($cards->data));

            return new JsonResponse($this->opensslEncrypt($fundingOrders->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}