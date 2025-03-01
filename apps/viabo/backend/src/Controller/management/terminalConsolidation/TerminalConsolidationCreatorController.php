<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\terminalConsolidation;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\catalogs\threshold\application\find\PayThresholdQuery;
use Viabo\management\terminalConsolidation\application\create\CreatorTerminalConsolidationCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class TerminalConsolidationCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $company = $this->ask(new CompanyQueryByUser(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            $threshold = $this->ask(new PayThresholdQuery('ViaboPay'));
            $this->dispatch(new CreatorTerminalConsolidationCommand(
                $company->data['id'],
                $tokenData['id'],
                $data['speiCardTransactionId'],
                $data['speiCardTransactionAmount'],
                $data['terminalId'],
                $data['transactions'],
                $threshold->data['threshold']
            ));

            return new JsonResponse([]);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
