<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Psr\Log\LoggerInterface;
use Viabo\security\shared\domain\user\UserEmail;
use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\services\UserFinderByCriteria;
use Viabo\security\user\domain\User;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class AddUsersEmailsQueryHandler implements QueryHandler
{
    public function __construct(private UserFinderByCriteria $finder , private LoggerInterface $notificationsLogger)
    {
    }

    public function __invoke(AddUsersEmailsQuery $query): Response
    {
        return new UserResponse(array_map(function (array $card) {
            $userId = new UserId($card['ownerId']);
            $user = $this->userFinder($userId);
            $card['ownerName'] = empty($user) ? '' : $user->name()->value();
            $card['ownerEmail'] = empty($user) ? '' : $user->email();
            return $card;
        } , $query->cards));
    }

    private function userFinder(UserId $userId): User|null
    {
        try {
            return $this->finder->__invoke($userId , UserEmail::empty());
        } catch (\DomainException $exception) {
            $this->notificationsLogger->error(
                $exception->getMessage() ,
                ['UserId' => $userId->value() , 'file' => $exception->getFile()]
            );
            return null;
        }
    }
}