<?php declare(strict_types=1);


namespace Viabo\backoffice\fee\application\find;


use Viabo\backoffice\fee\domain\Fee;
use Viabo\backoffice\fee\domain\FeeRepository;

final readonly class RatesFinder
{
    public function __construct(private FeeRepository $repository)
    {
    }

    public function __invoke(): FeeResponse
    {
        $data = [];
        $rates = $this->repository->searchAll();
        foreach ($rates as $fee) {
            $fee = $fee->toArray();
            $data[$fee['name']] = $fee['value'];
        }
        return new FeeResponse($data);
    }
}