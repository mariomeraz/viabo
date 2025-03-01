<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain\services;


use Viabo\management\receipt\domain\ReceiptRepository;
use Viabo\management\receipt\domain\Receipts;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardReceiptsFinder
{
    public function __construct(private ReceiptRepository $repository)
    {
    }

    public function __invoke(string $cardId): Receipts
    {
        $filters = Filters::fromValues([
            ['field' => 'cardId' , 'operator' => '=' , 'value' => $cardId]
        ]);

        $receipts = $this->repository->matching(new Criteria($filters));
        return new Receipts($receipts);
    }
}