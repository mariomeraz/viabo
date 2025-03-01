<?php declare(strict_types=1);


namespace Viabo\backoffice\logs\domain;


final class Log
{
    public function __construct(
        private LogId            $id ,
        private LogType          $type ,
        private LogAggregateId   $aggregateId ,
        private LogBody          $body ,
        private LogUpdatedByUser $updatedByUser ,
        private LogOccurredOn    $occurredOn
    )
    {
    }

    public static function create(string $commerceId , string $type , array $data): static
    {
        return new static(
            LogId::random() ,
            LogType::create($type) ,
            LogAggregateId::create($commerceId) ,
            LogBody::create($data) ,
            new LogUpdatedByUser($data['updatedByUser']) ,
            LogOccurredOn::todayDate()
        );
    }
}