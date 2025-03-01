import { PaymentLinkInfoAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const getPaymentLinkInfo = async paymentId => {
  const { data } = await axios.get(`/api/commerces/pay/${paymentId}`)
  return PaymentLinkInfoAdapter(data)
}

export const generateChargeFromPaymentLink = async charge => {
  const { data } = await axios.post('/api/commerce/pay/generate/transaction', charge)
  return data
}
