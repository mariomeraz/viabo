<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update;


use Viabo\backoffice\company\domain\Company;
use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\company\domain\services\CompanyFinder;
use Viabo\backoffice\company\domain\services\CompanyUpdater as CommerceUpdaterService;
use Viabo\backoffice\company\domain\services\EnsureBusinessRules;
use Viabo\backoffice\company\domain\services\LogoDataFinder;
use Viabo\backoffice\shared\domain\commerce\CompanyLegalRepresentative;
use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\uploadFile\UploadFileRepository;

final readonly class CommerceUpdaterByBackoffice
{
    public function __construct(
        private CompanyRepository      $repository ,
        private CommerceUpdaterService $updater ,
        private UploadFileRepository   $uploadFileRepository ,
        private CompanyFinder          $finder ,
        private EnsureBusinessRules    $ensureBusinessRules ,
        private LogoDataFinder         $logoDataFinder ,
        private EventBus               $bus
    )
    {
    }

    public function __invoke(
        string $userId ,
        string $commerceId ,
        string $tradeName ,
        string $fiscalName ,
        string $rfc ,
        string $fiscalPersonType ,
        string $employees ,
        string $branchOffices ,
        string $postalAddress ,
        string $phoneNumbers ,
        string $slug ,
        string $publicTerminal ,
        array  $logo
    ): void
    {
        $this->ensureBusinessRules->__invoke($commerceId , $tradeName , $slug);

        $commerce = $this->finder->commerce(new CompanyId($commerceId) , CompanyLegalRepresentative::empty());
        $logoData = $this->searchFileData($logo);
        $this->updater->byBackoffice($commerce , [
            'userId' => $userId ,
            'fiscalPersonType' => $fiscalPersonType ,
            'fiscalName' => $fiscalName ,
            'tradeName' => $tradeName ,
            'rfc' => $rfc ,
            'postalAddress' => $postalAddress ,
            'phoneNumbers' => $phoneNumbers ,
            'logoData' => $logoData ,
            'slug' => $slug ,
            'publicTerminal' => $publicTerminal ,
            'employees' => $employees ,
            'branchOffices' => $branchOffices
        ]);

        $this->repository->update($commerce);
        $this->uploadFiles($commerce , $logo);

        $this->bus->publish(...$commerce->pullDomainEvents());
    }

    private function searchFileData(array $logo): array
    {
        return empty($logo['logo']) ? [] : $this->logoDataFinder->__invoke($logo);
    }

    private function uploadFiles(Company $commerce , array $logo): void
    {
        $files = empty($logo['logo']) ? [] : $logo;
        array_map(function (object $file) use ($commerce) {
            $logoData = $commerce->logoData();
            $this->uploadFileRepository->upload(
                $file ,
                $logoData['directoryPath'] ,
                $logoData['allowedExtensions'] ,
                $logoData['name']
            );
        } , $files);
    }

}