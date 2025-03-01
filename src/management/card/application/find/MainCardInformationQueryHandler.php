<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardPassword;
use Viabo\management\card\domain\CardUser;
use Viabo\management\shared\domain\card\CardClientKey;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class MainCardInformationQueryHandler implements QueryHandler
{
    public function __construct(private CardInformationFinder $finder)
    {
    }

    public function __invoke(MainCardInformationQuery $query): Response
    {
        $cardId = new CardId($query->cardId);
        $clientKey = CardClientKey::create($query->credentialData['clientKey']);
        $user = CardUser::create($query->credentialData['userName']);
        $password = CardPassword::create($query->credentialData['password']);

        $response = ($this->finder)($cardId , $clientKey , $user , $password);

        return new CardResponse([
            'cardId' => $cardId->value() ,
            'balance' => $response->data['balance'] ,
            'spei' => $response->data['spei']
        ]);
    }
}