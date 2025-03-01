<?php declare(strict_types=1);


namespace Viabo\shared\domain\criteria;


final class OrSpecification
{

    private $filters;

    public function __construct()
    {
        $this->filters = Filters::empty();
    }

    public function add(Filters $filters): void
    {
        $this->filters = $filters;
    }

    public function count(): int
    {
        return $this->filters->count();
    }

    public function get(): array
    {
        return $this->filters->get();
    }
}