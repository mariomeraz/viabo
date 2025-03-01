<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\backoffice\company;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\find\CommercesAffiliatesQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommerceAffiliatesFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $affiliates = $this->ask(new CommercesAffiliatesQuery());

            return new JsonResponse($affiliates->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}