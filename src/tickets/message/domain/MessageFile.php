<?php declare(strict_types=1);


namespace Viabo\tickets\message\domain;


final class MessageFile
{
    public function __construct(
        private MessageFileId          $id ,
        private MessageFileReferenceId $messageId ,
        private MessageFileStoragePath $storagePath ,
        private MessageFileCreateDate  $createDate
    )
    {
    }

    public static function fromValue(array $value): static
    {
        return new static(
            MessageFileId::random() ,
            new MessageFileReferenceId($value['messageId']) ,
            MessageFileStoragePath::create($value['ticketId'] , $value['name']) ,
            MessageFileCreateDate::todayDate()
        );
    }

    public function directoryPath(): string
    {
        return $this->storagePath->directoryPath();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'messageId' => $this->messageId->value() ,
            'storagePath' => $this->storagePath->value() ,
            'createDate' => $this->createDate->value()
        ];
    }
}