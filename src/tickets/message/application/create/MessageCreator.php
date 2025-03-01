<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\create;


use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\uploadFile\UploadFileRepository;
use Viabo\tickets\message\domain\Message;
use Viabo\tickets\message\domain\MessageRepository;

final readonly class MessageCreator
{

    public function __construct(
        private MessageRepository    $repository ,
        private UploadFileRepository $uploadFileRepository ,
        private EventBus             $bus
    )
    {
    }

    public function __invoke(
        string $userId ,
        string $messageId ,
        string $ticketId ,
        string $description ,
        array  $uploadFile
    ): void
    {

        $files = $this->getFileDataAndMergeData($uploadFile , $ticketId , $messageId);

        $message = Message::create(
            $messageId ,
            $ticketId ,
            $description ,
            $files ,
            $userId
        );

        $this->repository->save($message);
        $this->storageFile($uploadFile , $message->directoryPath());

        $this->bus->publish(...$message->pullDomainEvents());


    }

    private function getFileDataAndMergeData(mixed $files , string $ticketId , string $messageId): array
    {
        if (empty($files['files'])) {
            return [];
        }

        $files = $files['files'];

        if (is_array($files)) {
            return array_map(function (object $file) use ($ticketId , $messageId) {
                $data = $this->uploadFileRepository->data($file);
                $data['ticketId'] = $ticketId;
                $data['messageId'] = $messageId;
                return $data;
            } , $files);
        }

        $data = $this->uploadFileRepository->data($files);
        $data['ticketId'] = $ticketId;
        $data['messageId'] = $messageId;
        return [$data];
    }

    private function storageFile(mixed $uploadFiles , string $directoryPath): void
    {
        if (empty($uploadFiles['files'])) {
            return;
        }

        $uploadFiles= $uploadFiles['files'];

        if (!is_array($uploadFiles)) {
            $this->uploadFileRepository->upload($uploadFiles , $directoryPath);
            return;
        }

        array_map(function (object $file) use ($directoryPath) {
            $this->uploadFileRepository->upload($file , $directoryPath);
        } , $uploadFiles);

    }
}