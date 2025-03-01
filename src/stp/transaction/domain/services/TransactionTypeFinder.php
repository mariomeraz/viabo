<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\services;


use Viabo\stp\transaction\domain\exceptions\TransactionTypeIdNotExist;
use Viabo\stp\transaction\domain\TransactionRepository;
use Viabo\stp\transaction\domain\TransactionTypeId;

final readonly class TransactionTypeFinder
{

    public function __construct(private TransactionRepository $repository)
    {
    }

    public function speiOutType(): TransactionTypeId
    {
        $typeId = $this->repository->searchType('1');

        if (empty($typeId)) {
            throw new TransactionTypeIdNotExist();
        }

        return $typeId;
    }

    public function speiInType(): TransactionTypeId
    {
        $typeId = $this->repository->searchType('2');

        if (empty($typeId)) {
            throw new TransactionTypeIdNotExist();
        }

        return $typeId;
    }
}