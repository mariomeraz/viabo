<?php declare(strict_types=1);


namespace Viabo\tickets\message\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\tickets\message\domain\Message;
use Viabo\tickets\message\domain\MessageFile;
use Viabo\tickets\message\domain\MessageRepository;

final class MessageDoctrineRepository extends DoctrineRepository implements MessageRepository
{
    public function __construct(EntityManager $TicketsEntityManager)
    {
        parent::__construct($TicketsEntityManager);
    }

    public function save(Message $message): void
    {
        $this->persist($message);
        array_map(function (MessageFile $file) {
            $this->persist($file);
        } , $message->files());
    }

    public function search(string $ticket , $limit , $offset): array
    {
        return $this->repository(Message::class)->findBy(
            ['ticketId.value' => $ticket] ,
            ['createDate.value' => 'Desc'] ,
            $limit ,
            $offset
        );
    }

    public function searchFiles(string $messageId): array
    {
        return $this->repository(MessageFile::class)->findBy(['messageId.value' => $messageId]);
    }

    public function searchTotal(string $ticket): int
    {
        $messages = $this->repository(Message::class)->findBy(['ticketId.value' => $ticket]);
        return count($messages);
    }

    public function searchLast(string $ticketId): Message|null
    {
        return $this->repository(Message::class)->findOneBy(
            ['ticketId.value' => $ticketId] ,
            ['createDate.value' => 'desc']
        );
    }
}