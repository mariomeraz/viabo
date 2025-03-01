<?php declare(strict_types=1);


namespace Viabo\news\news\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;

final class News extends AggregateRoot
{
    public function __construct(
        private NewsId        $id ,
        private NewsAlertType $alertType ,
        private NewsMessage   $message ,
        private NewsActive    $active
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'alertType' => $this->alertType->value() ,
            'message' => $this->message->value() ,
            'active' => $this->active->value()
        ];
    }
}