<?php declare(strict_types=1);


namespace Viabo\tickets\message\domain;


interface MessageRepository
{
    public function save(Message $message): void;

    public function search(string $ticket , $limit , $offset): array;

    public function searchFiles(string $messageId): array;

    public function searchTotal(string $ticket): int;

    public function searchLast(string $ticketId): Message|null;
}