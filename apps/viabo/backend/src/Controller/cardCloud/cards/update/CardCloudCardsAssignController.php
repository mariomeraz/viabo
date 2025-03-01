<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\cards\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\cards\application\assign_cards_in_company\AssignCardsCommandInCompany;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCloudCardsAssignController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $this->dispatch(new AssignCardsCommandInCompany($tokenData['businessId'], $data));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
