<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\card;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\card\application\find\CardInformationQuery;
use Viabo\management\card\application\find\CardsQuery;
use Viabo\management\credential\application\find\CardCredentialQuery;
use Viabo\security\session\application\find\SessionLastQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommerceCardStockFinderController extends ApiController
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
            $cards = $this->ask(new CardsQuery($company->data['id']));
            $cards = $this->addSessionLast($cards->data);
            $cards = $this->addCardBlock($cards);

            return new JsonResponse($this->opensslEncrypt($cards));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    private function addSessionLast(array $cards): array
    {
        return array_map(function (array $card) {
            $card['sessionLastDate'] = '';
            if (!empty($card['ownerId'])) {
                $session = $this->ask(new SessionLastQuery($card['ownerId']));
                $card['sessionLastDate'] = $session->data['loginDate'] ?? '';
            }
            return $card;
        }, $cards);
    }

    private function addCardBlock(array $cards): array
    {
        return array_map(function (array $card) {
            $credential = $this->ask(new CardCredentialQuery($card['id']));
            $cardInformation = $this->ask(new CardInformationQuery($card['id'], $credential->data));
            $card['block'] = $cardInformation->data['block'];
            return $card;
        }, $cards);
    }
}