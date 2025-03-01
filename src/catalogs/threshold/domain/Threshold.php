<?php declare(strict_types=1);


namespace Viabo\catalogs\threshold\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;

final class Threshold extends AggregateRoot
{
    public function __construct(
        private ThresholdId     $id ,
        private ThresholdName   $name ,
        private ThresholdValue  $value ,
        private ThresholdActive $active
    )
    {
    }
    public function value(): ThresholdValue
    {
        return $this->value;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'value' => $this->value->value()
        ];
    }
}
