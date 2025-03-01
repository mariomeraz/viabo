<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\card;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\card\application\find\MainCardIdQuery;
use Viabo\management\card\application\find\MainCardInformationQuery;
use Viabo\management\credential\application\find\CardCredentialQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class MainCardInformationFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $paymentProcessorId = $request->get('paymentProcessorId');
            $company = $this->ask(new CompanyQueryByUser(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            $cardData = $this->ask(new MainCardIdQuery($company->data['id'], $paymentProcessorId));
            $card = $this->searchCardData($cardData->data);

            return new JsonResponse($this->opensslEncrypt($card));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    private function searchCardData(array $cardData): array
    {
        if (empty($cardData['cardId'])) {
            return [];
        }

        $credential = $this->ask(new CardCredentialQuery($cardData['cardId']));
        $card = $this->ask(new MainCardInformationQuery($cardData['cardId'], $credential->data));
        return $card->data;

    }
}