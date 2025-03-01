<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\paymentProcessor;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\paymentProcessor\application\find\PaymentProcessorsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class PaymentProcessorsFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $paymentProcessors = $this->ask(new PaymentProcessorsQuery());

            return new JsonResponse($paymentProcessors->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}