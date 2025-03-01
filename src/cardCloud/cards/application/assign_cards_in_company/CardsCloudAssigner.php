<?php declare(strict_types=1);


namespace Viabo\cardCloud\cards\application\assign_cards_in_company;


use Viabo\cardCloud\shared\domain\CardCloudRepository;

final readonly class CardsCloudAssigner
{
    public function __construct(private CardCloudRepository $repository)
    {
    }

    public function __invoke(string $businessId, array $data): void
    {
        $this->repository->assignCards($businessId, $data);
    }
}