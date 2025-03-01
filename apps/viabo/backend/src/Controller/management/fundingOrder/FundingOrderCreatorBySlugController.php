<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\fundingOrder;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\card\application\find\MainCardsInformationQuery;
use Viabo\management\fundingOrder\application\create\CreateFundingOrderCommand;
use Viabo\management\fundingOrder\application\find\FundingOrderQuery;
use Viabo\management\notifications\application\SendFundingOrder\SendFundingOrderCommand;
use Viabo\security\api\application\find\ApiQuery;
use Viabo\shared\domain\Utils;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class FundingOrderCreatorBySlugController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $request = $this->opensslDecrypt($request->toArray());
            $card = $this->searchCard($request['commerceId']);
            $payCash = $this->ask(new ApiQuery('Pay_Cash'));
            $payCashInstructions = $this->ask(new ApiQuery('Pay_Cash_Instructions'));
            $fundingOrderId = $this->generateUuid();
            $emptySpei = '';
            $payCashActive = '1';
            $this->dispatch(new CreateFundingOrderCommand(
                $fundingOrderId ,
                $card['id'] ,
                $card['number'] ,
                $request['amount'] ,
                $emptySpei ,
                $payCashActive ,
                $payCash->data ,
                $payCashInstructions->data
            ));
            $fundingOrder = $this->ask(new FundingOrderQuery($fundingOrderId));
            $this->dispatch(new SendFundingOrderCommand($fundingOrder->data , $request['email']));

            return new JsonResponse($this->opensslEncrypt($fundingOrder->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }

    private function searchCard($commerceId): array
    {
        $cards = $this->ask(new MainCardsInformationQuery($commerceId));

        if (count($cards->data) > 1) {
            $card = array_filter($cards->data , function (array $data) {
                $masterCardPaymentProcessorId = '1';
                return $data['paymentProcessorId'] === $masterCardPaymentProcessorId;
            });
            $card = Utils::removeDuplicateElements($card);
            return $card[0];
        }

        return $cards->data[0];

    }
}