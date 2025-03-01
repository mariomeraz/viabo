<?php

namespace Viabo\Backend\Controller\backoffice\company;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\find\CommerceQuery;
use Viabo\management\commerceTerminal\application\find\VirtualTerminalsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommerceFinderController extends ApiController
{

    public function __invoke(string $commerceId , Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $commerce = $this->ask(new CommerceQuery($commerceId));
            $terminals = $this->ask(new VirtualTerminalsQuery($commerce->data['id']));
            $commerce = $this->mergeData($commerce->data , $terminals->data);

            return new JsonResponse($commerce);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }

    private function mergeData(array $commerce , array $terminals): array
    {
        $terminals = array_map(function (array $data) {
            return ['id' => $data['id'] , 'name' => $data['name'] , 'type' => $data['typeId']];
        } , $terminals);

        $commerce['terminals'] = $terminals;
        return $commerce;
    }
}