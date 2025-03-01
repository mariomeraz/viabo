<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\find;


use Viabo\management\cardOperation\domain\CardOperation;
use Viabo\management\cardOperation\domain\CardOperationRepository;

final readonly class AllCardsOperationsFinder
{
    public function __construct(private CardOperationRepository $repository)
    {
    }

    public function __invoke(): CardsOperationsResponse
    {
        $operations = $this->repository->searchAll();
        return new CardsOperationsResponse(array_map(function (CardOperation $operation) {
            return $operation->toArray();
        } , $operations));
    }
}