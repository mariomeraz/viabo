import { GlobalCardsAdapter, MasterMovementsAdapter } from '@/app/business/dashboard-master/adapters'
import { CardsAdapter } from '@/app/shared/adapters'
import { axios } from '@/shared/interceptors'

export const getGlobalCards = async () => {
  const { data } = await axios.get(`/api/main-cards/information`)
  return GlobalCardsAdapter(data)
}

export const getMasterMovements = async (initialDate, finalDate, signal) => {
  const fetchURL = new URL('/api/master-cards/movements', window.location.origin)
  fetchURL.searchParams.set('startDate', initialDate)
  fetchURL.searchParams.set('endDate', finalDate)
  const { data } = await axios.get(fetchURL.href)
  return MasterMovementsAdapter(data)
}

export const getCommerceCardsByPaymentProcessors = async paymentProcessors => {
  const resultsByPaymentProcessorId = {}
  const requests = paymentProcessors.map(paymentProcessorId =>
    axios
      .get(`/api/enabled-cards/commerce?paymentProcessorId=${paymentProcessorId}`)
      .then(response => CardsAdapter(response.data))
      .then(cards => {
        // Almacena los resultados en el objeto resultsByPaymentProcessorId
        resultsByPaymentProcessorId[paymentProcessorId] = cards
      })
  )
  await Promise.all(requests)

  return resultsByPaymentProcessorId
}
