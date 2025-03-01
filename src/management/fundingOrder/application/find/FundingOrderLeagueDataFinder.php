<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\find;


use Viabo\management\fundingOrder\application\create\FundingOrderResponse;
use Viabo\management\fundingOrder\domain\FundingOrderReferenceNumber;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\fundingOrder\domain\exceptions\FundingOrderNotExist;

final readonly class FundingOrderLeagueDataFinder
{
    public function __construct(private FundingOrderRepository $repository)
    {
    }

    public function __invoke(FundingOrderReferenceNumber $referenceNumber): FundingOrderResponse
    {
        $fundingOrder = $this->repository->searchReferenceNumber($referenceNumber);

        if (empty($fundingOrder)) {
            throw new FundingOrderNotExist();
        }

        $data = $fundingOrder->toArray();
        return new FundingOrderResponse([
            'spei' => $data['spei'] ,
            'amount' => $data['amountFormat'] ,
            'referenceNumber' => $data['referenceNumber'] ,
            'referencePayCash' => $data['referencePayCash'] ,
            'urlPayCashFormat' => $data['instructionsUrls']['format'] ?? '' ,
            'urlPayCashDownload' => $data['instructionsUrls']['download'] ?? ''
        ]);
    }
}