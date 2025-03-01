<?php declare(strict_types=1);

namespace Viabo\management\card\application\find;

use Viabo\management\card\domain\CardPassword;
use Viabo\management\card\domain\CardUser;
use Viabo\management\card\domain\services\CardFinder as CardFinderService;
use Viabo\management\shared\domain\card\CardClientKey;
use Viabo\management\shared\domain\card\CardId;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\management\shared\domain\paymentProcessor\PaymentProcessorAdapter;

final readonly class FinderCardsMasterGlobal
{
    public function __construct(
        private CardFinderService       $finder ,
        private PaymentProcessorAdapter $adapter
    )
    {
    }

    public function __invoke(array $cardsInformation, array $balanceMaster):CardsMasterGlobalResponse
    {
        $global = [];
        foreach ($cardsInformation as $card) {
            $cardId = new CardId($card['cardId']);
            $cardNumber = new CardNumber($card['number']);
            $clientKey = CardClientKey::create($card['clientKey']);
            $user = CardUser::create($card['userName']);
            $password = CardPassword::create($card['password']);

            $cardEntity = $this->finder->__invoke($cardId);
            $cardEntity->registerCredentials($clientKey, $user, $password);
            $data = $this->adapter->searchCardBalance($cardEntity);
            $cardEntity->updateSETData($data);
            $cardData = $cardEntity->toArray();
            $global[] =[
                'paymentProcessor' => $card['paymentProcessor'],
                'balance' => $cardData['balance'] ,
                'inTransit' => $balanceMaster[$card['paymentProcessorId']],
                'cardId' => $cardId->value() ,
                'cardNumber' => $cardNumber->value() ,
                'spei' => $cardData['spei'],
                'block'=> $cardData['block']
            ];
        }

        return new CardsMasterGlobalResponse($global);

    }
}
