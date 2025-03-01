import { ViaboSpeiMovementsAdapter, ViaboSpeiResumeBalance } from '../adapters'

import { axios } from '@/shared/interceptors'

export const getBalanceResumeViaboSpei = async filters => {
  const { data } = await axios.get('/api/spei/transaccions/balance', {
    params: filters
  })

  return ViaboSpeiResumeBalance(data)
}

export const createSpeiOut = async transactions => {
  const { data } = await axios.post('/api/spei/transaction/process-payments', transactions)
  if (data && Array.isArray(data)) {
    return data?.map(operation => ({
      account: operation?.destinationsAccount,
      url: operation?.url
    }))
  }

  throw new Error('Se realizo las transacciones pero no se obtuvo los comprobantes de las operaciones')
}

export const getMovementsViaboSpei = async filters => {
  const { data } = await axios.get('/api/spei/transaccions', {
    params: filters
  })

  return ViaboSpeiMovementsAdapter(data)
}
