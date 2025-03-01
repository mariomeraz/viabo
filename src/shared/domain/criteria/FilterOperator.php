<?php declare(strict_types=1);


namespace Viabo\shared\domain\criteria;


enum FilterOperator: string
{
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case NEQ = '<>';
    case GT = '>';
    case GTE = '>=';
    case LT = '<';
    case LTE = '<=';
    case CONTAINS = 'CONTAINS';
    case NOT_CONTAINS = 'NOT_CONTAINS';
    case IN = 'IN';
    case NIN = 'NIN';
    case ENDS_WITH = 'ENDS_WITH';

    public function isContaining(): bool
    {
        return in_array($this->value , [self::CONTAINS->value , self::NOT_CONTAINS->value] , true);
    }

    public function isIN(): bool
    {
        return $this->value === self::IN->value;
    }

    public function isNotIN(): bool
    {
        return $this->value === self::NIN->value;
    }
}