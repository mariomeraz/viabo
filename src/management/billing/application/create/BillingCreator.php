<?php declare(strict_types=1);


namespace Viabo\management\billing\application\create;


use Viabo\backoffice\commission\application\find\CommissionChargeQuery;
use Viabo\management\billing\domain\Billing;
use Viabo\management\billing\domain\BillingAmount;
use Viabo\management\billing\domain\BillingApiKey;
use Viabo\management\billing\domain\BillingCardNumber;
use Viabo\management\billing\domain\BillingCommission;
use Viabo\management\billing\domain\BillingCommissionPercentage;
use Viabo\management\billing\domain\BillingCommissionType;
use Viabo\management\billing\domain\BillingData;
use Viabo\management\billing\domain\BillingRepository;
use Viabo\management\billing\domain\exceptions\BillingExist;
use Viabo\management\billing\domain\services\BillingFinderByApiKey;
use Viabo\management\card\application\find\CardQueryByNumber;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class BillingCreator
{
    private BillingFinderByApiKey $finder;

    public function __construct(
        private BillingRepository $repository ,
        private QueryBus          $queryBus ,
        private EventBus          $bus
    )
    {
        $this->finder = new BillingFinderByApiKey($this->repository);
    }

    public function __invoke(
        BillingApiKey     $apiKey ,
        BillingCardNumber $cardNumber ,
        BillingAmount     $amount ,
        BillingData       $depositData
    ): void
    {
        $this->ensureNotExist($apiKey);

        $commission = $this->commission($cardNumber , $amount);
        $billing = Billing::create(
            $apiKey ,
            $cardNumber ,
            new BillingCommissionType($commission['type']) ,
            $amount ,
            new BillingCommissionPercentage($commission['percentage']) ,
            new BillingCommission($commission['charge']) ,
            $depositData
        );
        $this->repository->save($billing);

        $this->bus->publish(...$billing->pullDomainEvents());
    }

    private function ensureNotExist(BillingApiKey $apiKey): void
    {
        $billing = $this->finder->__invoke($apiKey);
        if (!empty($billing)) {
            throw new BillingExist();
        }
    }

    private function commission(BillingCardNumber $cardNumber , BillingAmount $amount): array
    {
        try {
            $card = $this->queryBus->ask(new CardQueryByNumber($cardNumber->value()));
            $commission = $this->queryBus->ask(new CommissionChargeQuery(
                $card->data['commerceId'] ,
                $card->data['paymentProcessorName'] ,
                $amount->value()
            ));
            return $commission->data;
        } catch (\DomainException $exception) {
            throw new \DomainException($exception->getMessage() , 400);
        }
    }
}