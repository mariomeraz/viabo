<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\backoffice\crypt;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\crypt\application\find\CryptQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CryptController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $data = $request->toArray();
            $crypt = $this->ask(new CryptQuery($data['value'] , $data['encrypt']));

            return new JsonResponse($crypt->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}