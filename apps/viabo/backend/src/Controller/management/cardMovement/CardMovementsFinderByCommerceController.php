<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\cardMovement;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\card\application\find\AllCardsQueryByCommerce;
use Viabo\management\cardMovement\application\find\CardsMovementsQueryByCommerce;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardMovementsFinderByCommerceController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $filters = $request->get('filters');
            $company = $this->ask(new CompanyQueryByUser(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            $cards = $this->ask(new AllCardsQueryByCommerce($company->data['id']));
            $movements = $this->ask(new CardsMovementsQueryByCommerce($cards->data , $filters));

            return new JsonResponse($this->opensslEncrypt($movements->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}