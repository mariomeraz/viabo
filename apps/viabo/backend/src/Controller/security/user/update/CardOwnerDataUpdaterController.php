<?php

namespace Viabo\Backend\Controller\security\user\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\user\application\update\UpdateCardOwnerDataCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class CardOwnerDataUpdaterController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $data = $this->opensslDecrypt($request->toArray());
            $this->dispatch(new UpdateCardOwnerDataCommand(
                $data['ownerId'] ,
                $data['name'] ,
                $data['lastName'] ,
                $data['phone']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
