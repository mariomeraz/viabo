<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\backoffice\projection\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\backoffice\projection\application\find_card_cloud_owners\CardCloudOwnersQuery;

final readonly class CardCloudOwnersFinderController extends ApiController
{

    public function __invoke(string $companyId, Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $cardCloudOwners = $this->ask(new CardCloudOwnersQuery($companyId));

            return new JsonResponse($cardCloudOwners->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
