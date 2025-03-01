<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain\services;


use Viabo\backoffice\company\domain\Company;
use Viabo\backoffice\company\domain\exceptions\CompanySlugExist;
use Viabo\backoffice\company\domain\exceptions\CompanySlugHasSpaces;
use Viabo\backoffice\company\domain\exceptions\CompanySlugNotHaveTerminalVirtual;
use Viabo\backoffice\company\domain\exceptions\CompanyTradeNameExist;
use Viabo\management\commerceTerminal\application\find\VirtualTerminalsQuery;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class EnsureBusinessRules
{
    public function __construct(
        private CompanyFinder $finder ,
        private QueryBus      $queryBus
    )
    {
    }

    public function __invoke(string $commerceId , string $tradeName , string $slug): void
    {
        $this->ensureTradeName($commerceId , $tradeName);
        $this->ensureSlug($commerceId , $slug);
    }

    public function ensureTradeName(string $commerceId , string $tradeName): void
    {
        $commerce = $this->searchCommerceByTradeName($commerceId , $tradeName);
        if (!empty($commerce)) {
            throw new CompanyTradeNameExist();
        }
    }

    private function ensureSlug(string $commerceId , string $slug): void
    {
        if (empty($slug)) {
            return;
        }

        if (!preg_match("/^\S+$/", $slug)) {
            throw new CompanySlugHasSpaces();
        }

        $commerce = $this->searchCommerceBySlug($commerceId , $slug);
        if (!empty($commerce)) {
            throw new CompanySlugExist();
        }

        $terminals = $this->queryBus->ask(new VirtualTerminalsQuery($commerceId));
        if (empty($terminals)) {
            throw new CompanySlugNotHaveTerminalVirtual();
        }

    }

    private function searchCommerceByTradeName(string $commerceId , string $tradeName): Company|null
    {
        $filters = Filters::fromValues([
            ['field' => 'id' , 'operator' => '<>' , 'value' => $commerceId] ,
            ['field' => 'tradeName.value' , 'operator' => '=' , 'value' => $tradeName]
        ]);
        try {
            return $this->finder->searchCriteria(new Criteria($filters));
        } catch (\DomainException) {
            return null;
        }
    }

    private function searchCommerceBySlug(string $commerceId , string $slug): Company|null
    {
        $filters = Filters::fromValues([
            ['field' => 'id' , 'operator' => '<>' , 'value' => $commerceId] ,
            ['field' => 'slug.value' , 'operator' => '=' , 'value' => $slug]
        ]);
        try {
            return $this->finder->searchCriteria(new Criteria($filters));
        } catch (\DomainException) {
            return null;
        }
    }
}