import { CardMovementsAdapter } from '@/app/shared/adapters'
import { axios } from '@/shared/interceptors'

export const getExpensesMovementsCommerceCards = async (startDate, endDate, signal) => {
  const fetchURL = new URL('/api/cards/movements/commerce', window.location.origin)

  const filters = [
    { field: 'date', operator: '>=', value: startDate },
    { field: 'date', operator: '<=', value: endDate },
    { field: 'operationType', operator: '=', value: 'OTROS CARGOS' }
  ]

  filters?.forEach((filter, index) => {
    Object.entries(filter).forEach(([key, value]) => {
      fetchURL.searchParams.set(`filters[${index}][${key}]`, value)
    })
  })
  const { data } = await axios.get(fetchURL.href, {
    signal
  })
  return CardMovementsAdapter(data)
}
