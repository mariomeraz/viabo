<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Ramsey\Uuid\Uuid as RamseyUuid;
use Viabo\shared\domain\utils\DatePHP;

final class CompanySpeiCommissions
{
    public function __construct(
        private string  $id,
        private Company $company,
        private float   $speiOut,
        private float   $speiIn,
        private float   $internal,
        private float   $feeStp,
        private float   $stpAccount,
        private string  $updatedByUser,
        private string  $updatedDate,
        private string  $createdByUser,
        private string  $createDate
    )
    {
    }

    public static function create(Company $company, array $commissions): static
    {
        $date = new DatePHP();
        return new static(
            RamseyUuid::uuid4()->toString(),
            $company,
            $commissions['speiOut'],
            $commissions['speiIn'],
            $commissions['internal'],
            $commissions['feeStp'],
            $commissions['stpAccount'] ?? 0,
            '',
            '0000-00-00 00:00:00',
            $company->createdByUser(),
            $date->dateTime()
        );
    }

    public static function empty(Company $company): static
    {
        $date = new DatePHP();
        return new static(
            RamseyUuid::uuid4()->toString(),
            $company,
            0,
            0,
            0,
            0,
            0,
            '',
            '0000-00-00 00:00:00',
            '',
            $date->dateTime()
        );
    }

    public function update(array $commissions): void
    {
        $date = new DatePHP();
        $this->speiOut = $commissions['speiOut'];
        $this->speiIn = $commissions['speiIn'];
        $this->internal = $commissions['internal'];
        $this->feeStp = $commissions['feeStp'];
        $this->stpAccount = $commissions['stpAccount'] ?? 0;
        $this->updatedByUser = $this->company->updateByUser();
        $this->updatedDate = $date->dateTime();
    }

    public function value(): array
    {
        return [
            'speiOut' => $this->speiOut,
            'speiIn' => $this->speiIn,
            'internal' => $this->internal,
            'feeStp' => $this->feeStp,
            'stpAccount' => $this->stpAccount,
            'updatedByUser' => $this->updatedByUser
        ];
    }

}