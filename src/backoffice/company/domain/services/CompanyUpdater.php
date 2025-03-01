<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain\services;


use Viabo\backoffice\company\domain\Company;

final readonly class CompanyUpdater
{

    public function byBackoffice(Company $commerce , array $data): Company
    {
        $oldData = $commerce->toArray();
        $data['pointSaleTerminal'] = $oldData['pointSaleTerminal'];
        $data['paymentApi'] = $oldData['paymentApi'];
        $data['registerStep'] = $oldData['registerStep'];
        return $this->update($commerce , $data);
    }

    public function byRegistration(Company $commerce , array $data): Company
    {
        $oldData = $commerce->toArray();
        $data['postalAddress'] = $oldData['postalAddress'];
        $data['phoneNumbers'] = $oldData['phoneNumbers'];
        $data['logoData'] = [];
        $data['slug'] = $oldData['slug'];
        $data['publicTerminal'] = $oldData['publicTerminal'];
        return $this->update($commerce , $data);
    }

    private function update(Company $commerce , array $data): Company
    {
        $commerce->updateByClient(
            $data['userId'] ,
            $data['fiscalPersonType'] ,
            $data['fiscalName'] ,
            $data['tradeName'] ,
            $data['rfc'] ,
            $data['postalAddress'] ,
            $data['phoneNumbers'] ,
            $data['logoData'] ,
            $data['slug'] ,
            $data['publicTerminal'] ,
            $data['employees'] ,
            $data['branchOffices'] ,
            $data['pointSaleTerminal'] ,
            $data['paymentApi'] ,
            $data['registerStep']
        );
        return $commerce;
    }
}