<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain\card;


use Viabo\backoffice\commission\domain\Commission;
use Viabo\backoffice\commission\domain\CommissionCreateDate;
use Viabo\backoffice\commission\domain\CommissionCreatedByUser;
use Viabo\backoffice\commission\domain\CommissionId;
use Viabo\backoffice\commission\domain\CommissionUpdateDate;
use Viabo\backoffice\commission\domain\CommissionUpdatedByUser;
use Viabo\backoffice\shared\domain\company\CompanyId;

final class CommissionCard extends Commission
{
    public function __construct(
        CommissionId                            $id,
        CompanyId                               $companyId,
        private CommissionCardSpeiInCarnet      $speiInCarnet,
        private CommissionCardSpeiInMasterCard  $speiInMasterCard,
        private CommissionCardSpeiOutCarnet     $speiOutCarnet,
        private CommissionCardSpeiOutMasterCard $speiOutMasterCard,
        private CommissionCardPay               $pay,
        private CommissionCardSharedTerminal    $sharedTerminal,
        CommissionUpdatedByUser                 $updatedByUser,
        CommissionUpdateDate                    $updateDate,
        CommissionCreatedByUser                 $createdByUser,
        CommissionCreateDate                    $createDate
    )
    {
        parent::__construct($id, $companyId, $updatedByUser, $updateDate, $createdByUser, $createDate);
    }


    public function update(array $data): void
    {
        // TODO: Implement update() method.
    }

    protected function type(): string
    {
        return '1';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'type' => $this->type(),
            'companyId' => $this->companyId->value(),
            'speiInCarnet' => $this->speiInCarnet->value(),
            'speiInMasterCard' => $this->speiInMasterCard->value(),
            'speiOutCarnet' => $this->speiOutCarnet->value(),
            'speiOutMasterCard' => $this->speiOutMasterCard->value(),
            'pay' => $this->pay->value(),
            'sharedTerminal' => $this->sharedTerminal->value(),
            'updateByUser' => $this->updatedByUser->value(),
            'updateDate' => $this->updateDate->value(),
            'createdByUser' => $this->createdByUser->value(),
            'createDate' => $this->createDate->value()
        ];
    }
}