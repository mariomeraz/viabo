<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\terminalTransaction;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\terminalTransaction\application\find\CommercePayQueryByUrlCode;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommercePayFinderController extends ApiController
{
    public function __invoke(string $urlCode , Request $request): Response
    {
        try {
            $commercePay = $this->ask(new CommercePayQueryByUrlCode($urlCode));

            return new JsonResponse($this->opensslEncrypt($commercePay->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
