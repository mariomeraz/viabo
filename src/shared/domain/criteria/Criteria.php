<?php declare(strict_types=1);


namespace Viabo\shared\domain\criteria;


final class Criteria
{
    private Filters $or;
    public function __construct(
        private readonly Filters $filters ,
        private readonly Order   $order = new Order(new OrderBy('') , OrderType::NONE) ,
        private readonly ?int    $offset = null ,
        private readonly ?int    $limit = null
    )
    {
        $this->or = new Filters([]);
    }

    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    public function plainFilters(): array
    {
        return $this->filters->get();
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function addOr(Filters $filters): void
    {
        $this->or = $filters;
    }

    public function hasFiltersOr(): bool
    {
        return $this->or->count() > 0;
    }

    public function filtersOr(): array
    {
        return $this->or->get();
    }

    public function serialize(): string
    {
        return sprintf(
            '%s~~%s~~%s~~%s' ,
            $this->filters->serialize() ,
            $this->order->serialize() ,
            $this->offset ?? 'none' ,
            $this->limit ?? 'none'
        );
    }

    public function getWhereSQL(): string
    {
        return $this->filters->sql();
    }
}