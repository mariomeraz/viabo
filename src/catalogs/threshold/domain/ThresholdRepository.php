<?php declare(strict_types=1);


namespace Viabo\catalogs\threshold\domain;


use Viabo\shared\domain\criteria\Criteria;

interface ThresholdRepository
{
    public function searchCriteria(Criteria $criteria): array;
}