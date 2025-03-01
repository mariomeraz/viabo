<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\find;


use Viabo\tickets\message\domain\Message;
use Viabo\tickets\message\domain\MessageRepository;

final readonly class MessagesFinder
{
    public function __construct(private MessageRepository $repository)
    {
    }

    public function __invoke(
        string $userId ,
        string $userProfileId ,
        string $ticket ,
        int    $limit ,
        int    $page
    ): MessageResponse
    {

        $total = $this->repository->searchTotal($ticket);
        $offset = ($page - 1) * $limit;
        $messages = $this->repository->search($ticket , $limit , $offset);
        $messages = array_map(function (Message $message) use ($userId) {
            $files = $this->repository->searchFiles($message->id());
            $message->setFiles($files);
            $message->markMessageAsUser($userId);
            return $message->toArray();
        } , $messages);

        return new MessageResponse([
            'messages' => $messages ,
            'limit' => $limit ,
            'page' => $page ,
            'total' => $total
        ]);
    }

}