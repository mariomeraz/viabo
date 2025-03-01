<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\billing;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\billing\application\create\CreatePayCashBillingCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class PayCashBillingCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $data = $request->toArray();
            $this->dispatch(new CreatePayCashBillingCommand($data['payment']));

            return new JsonResponse(['code' => 200 , 'message' => 'payment successfully notified']);
        } catch (\DomainException $exception) {
            return new JsonResponse(
                ['code' => $exception->getCode() , 'message' => $exception->getMessage()]
            );
        }
    }
}