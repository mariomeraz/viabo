import { convertCatalogToReactSelect } from '@/shared/utils'

export const SpeiBanksAdapter = banks => {
  const banksAdapted =
    banks?.map(bank => ({
      id: bank?.id,
      stpCode: bank?.code,
      name: `${bank?.shortName} - ${bank?.code}`,
      commercialName: bank?.name,
      status: bank?.active === '1'
    })) || []

  return convertCatalogToReactSelect(banksAdapted, 'id', 'name', 'status')
}
