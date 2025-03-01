import { convertCatalogToReactSelect, fCurrency } from '@/shared/utils'

export const SpeiCompaniesListAdapter = companies => {
  const companiesAdapted =
    companies?.map(company => ({
      id: company?.id,
      folio: company?.folio,
      name: company?.tradeName,
      balance: fCurrency(company?.balance || '0'),
      status: company?.active === '1',
      rfc: company?.rfc,
      stpAccount: {
        complete: company?.bankAccount,
        hidden: company?.bankAccount?.replace(/.(?=.{8})/g, '*')
      }
    })) || []

  return convertCatalogToReactSelect(companiesAdapted, 'id', 'name')
}
