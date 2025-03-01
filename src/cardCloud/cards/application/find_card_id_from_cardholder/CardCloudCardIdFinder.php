<?php declare(strict_types=1);


namespace Viabo\cardCloud\cards\application\find_card_id_from_cardholder;


use Viabo\cardCloud\cards\application\CardCloudServiceResponse;
use Viabo\cardCloud\shared\domain\CardCloudRepository;

final readonly class CardCloudCardIdFinder
{
    public function __construct(private CardCloudRepository $repository)
    {
    }

    public function __invoke(string $number, string $nip, string $date): CardCloudServiceResponse
    {
        $cardId = $this->repository->searchCardId($number, $nip, $date);
        return new CardCloudServiceResponse($cardId);
    }
}