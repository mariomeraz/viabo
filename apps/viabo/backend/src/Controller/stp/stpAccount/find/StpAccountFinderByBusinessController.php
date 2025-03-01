<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\stpAccount\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\stpAccount\application\find_stp_account_by_business\StpAccountQueryByBusiness;


final readonly class StpAccountFinderByBusinessController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $stpAccounts = $this->ask(new StpAccountQueryByBusiness($tokenData['businessId']));

            return new JsonResponse([['id' => $stpAccounts->data['id'], 'name' => $stpAccounts->data['company']]]);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

}