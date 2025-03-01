<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\management\billing\domain\BillingReferencePayCash;
use Viabo\management\billing\domain\BillingRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\shared\domain\utils\DatePHP;

final readonly class BillingPayCashFinder
{
    public function __construct(private BillingRepository $repository, private DatePHP $date)
    {
    }

    public function __invoke(BillingReferencePayCash $reference): DepositReferenceResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'reference.value' , 'operator' => '=' , 'value' => $reference->value()]
        ]);
        $billing = $this->repository->searchBillingPayCashCriteria(new Criteria($filters));

        return new DepositReferenceResponse($this->formatData($billing));
    }

    private function formatData(array $billing): array
    {
        $record = ['payCashData' => ['folio' => '' , 'date' => '' , 'authorizationCode' => '']];
        if (empty($billing)) {
            return $record;
        }

        $data = json_decode($billing[0]->toArray()['data'] , true);
        $record['payCashData'] = [
            'folio' => $data['Folio'] ,
            'date' => $this->date->formatDateTime($data['FechaConfirmation']) ,
            'authorizationCode' => $data['Autorizacion']
        ];

        return $record;
    }
}