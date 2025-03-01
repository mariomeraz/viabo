<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\billing;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\billing\application\create\CreateBillingCommand;
use Viabo\management\billing\application\find\DepositReferenceQuery;
use Viabo\management\billing\application\find\FailedOperationBillingValidateCommand;
use Viabo\security\api\application\find\ValidateApiKeyCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class BillingCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $token = $request->headers->get('Authorization');
            $data = $request->toArray();
            $this->dispatch(new ValidateApiKeyCommand('Commission_Billing' , $token));
            $this->dispatch(new CreateBillingCommand($data));
            $this->dispatch(new FailedOperationBillingValidateCommand($data['key'] ?? null));
            $depositReference = $this->ask(new DepositReferenceQuery($data['key'] ?? null));

            return new JsonResponse($this->formatResponse($depositReference->data));
        } catch (\DomainException $exception) {
            $success = false;
            return new JsonResponse(
                $this->formatResponse($exception->getMessage() , $success , $exception->getCode()) ,
                $exception->getCode()
            );
        }
    }
}