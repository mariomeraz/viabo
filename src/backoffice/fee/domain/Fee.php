<?php declare(strict_types=1);


namespace Viabo\backoffice\fee\domain;


final class Fee
{
    public function __construct(
        private FeeId    $id,
        private FeeName  $name,
        private FeeValue $value
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'value' => $this->value->value(),
        ];

    }
}