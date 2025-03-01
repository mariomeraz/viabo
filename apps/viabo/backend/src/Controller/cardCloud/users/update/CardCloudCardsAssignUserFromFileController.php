<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\users\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_subaccount_card_cloud_by_company\CardCloudSubAccountQueryByCompany;
use Viabo\backoffice\users\application\assign_user_in_company\AssignUserCommandInCompany;
use Viabo\cardCloud\cards\application\find_sub_account_cards\CardCloudSubAccountCardsQuery;
use Viabo\cardCloud\users\application\assign_cards_in_user_from_file\AssignCardsCloudCommandInUserFromFile;
use Viabo\cardCloud\users\application\find_users_by_business\CardCloudUsersQuery;
use Viabo\security\user\application\create_user_by_assign_card_cloud\CreateUserCardCloudOwnerCommand;
use Viabo\security\user\application\find\UserQueryByUsername;
use Viabo\shared\domain\excel\ExcelRepository;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCloudCardsAssignUserFromFileController extends ApiController
{

    public function __invoke(Request $request, ExcelRepository $excelRepository): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $businessId = $tokenData['businessId'];
            $data = $request->request->all();
            $fileData = $excelRepository->data($request->files->get('file'));
            $data['cards'] = $this->searchCards($data['companyId'], $businessId);
            $fileData = $this->formatData($fileData, $data, $businessId);
            $errorData = $this->assignCardsInUser($businessId, $tokenData['id'], $fileData);

            return new JsonResponse($errorData);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function searchCards(string $companyId, string $businessId): array
    {
        $cardCloudSubAccount = $this->ask(new CardCloudSubAccountQueryByCompany($companyId));
        $users = $this->ask(new CardCloudUsersQuery($businessId));
        $cardCloudCards = $this->ask(new CardCloudSubAccountCardsQuery(
            $businessId,
            $cardCloudSubAccount->data['subAccount'],
            $users->data
        ));
        return $cardCloudCards->data;
    }

    private function formatData(array $fileData, array $data, string $businessId): array
    {
        $registers = [];
        array_map(function ($row) use ($businessId, $data, &$registers) {
            $userData = [
                'bin' => $row[0] ?? '',
                'name' => $row[1] ?? '',
                'lastname' => $row[2] ?? '',
                'phone' => $row[3] ?? '',
                'email' => $row[4] ?? '',
                'error' => false,
                'message' => ''
            ];
            $userId = $this->userId($businessId, $data['companyId'], $userData);
            $cardId = $this->cardId($userData, $data['cards']);
            $registers[] = [
                'companyId' => $data['companyId'],
                'cards' => [$cardId],
                'user' => $userId,
                'isPending' => empty($row[4]),
                'userData' => $userData
            ];
        }, $fileData);
        return $registers;
    }

    private function userId(string $businessId, string $companyId, array &$userData): string
    {
        if (empty($userData['name'])) {
            $userData['error'] = true;
            $userData['message'] = 'No esta definido el nombre del usuario';
            return '';
        }

        if (empty($userData['email'])) {
            return $this->generateUser($businessId, $companyId, $userData);
        }

        try {
            $user = $this->ask(new UserQueryByUsername($userData['email']));

            $ownerProfile = '8';
            if ($user->data['profileId'] !== $ownerProfile) {
                $userData['error'] = true;
                $userData['message'] = 'No se le puede asignar tarjetas al usuario por su perfil';
                return '';
            }

            return $user->data['id'];
        } catch (\DomainException) {
            return $this->generateUser($businessId, $companyId, $userData);
        }
    }

    private function generateUser(string $businessId, string $companyId, array &$userData): string
    {
        try {
            $userId = $this->generateUuid();
            $this->dispatch(new CreateUserCardCloudOwnerCommand($businessId, $userId, $userData));
            $this->dispatch(new AssignUserCommandInCompany($businessId, $companyId, $userId));
            return $userId;
        } catch (\DomainException) {
            $userData['error'] = true;
            $userData['message'] = 'Ya esta registrado el usuario';
            return '';
        }
    }

    private function cardId(array &$userData, array $cards): string|null
    {
        $cardBin = $userData['bin'];
        $cardIds = array_map(function ($card) use ($cardBin) {
            return $card['bin'] === $cardBin ? $card['card_id'] : '';
        }, $cards);
        $cardId = array_values(array_filter($cardIds));

        if (empty($cardId)) {
            $userData['message'] = 'No existe el numero de tarjeta';
            return '';
        }

        return $cardId[0];
    }

    private function assignCardsInUser(string $businessId, string $userId, array $fileData): array
    {
        $errorData = [];
        foreach ($fileData as $data) {
            try {
                $this->dispatch(new AssignCardsCloudCommandInUserFromFile($businessId, $userId, $data));
            } catch (\DomainException $exception) {
                $userData = $this->updateUserData($data, $exception->getMessage());
                $cards = $this->getCardNumbers($userData);
                $this->appendErrorData($cards, $userData, $errorData);
            }
        }
        return $errorData;
    }

    private function updateUserData(mixed $data, string $exception): array
    {
        unset($data['userData']['error']);
        $message = $data['userData']['message'];
        $data['userData']['message'] = empty($message) ? $exception : $message;
        return $data['userData'];
    }

    private function appendErrorData(array $cards, array $userData, array &$errorData): void
    {
        if (count($cards) > 1) {
            foreach ($cards as $card) {
                $userData['bin'] = $card;
                $errorData[] = $userData;
            }
        } else {
            $errorData[] = $userData;
        }
    }

    private function getCardNumbers(array $userData): array
    {
        return explode(',', $userData['bin']);
    }

}
