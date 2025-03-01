import { ViaboPayLiquidatedMovementsAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const getViaboPayLiquidatedMovements = async (startDate, endDate, signal) => {
  const fetchURL = new URL('/api/terminals/shared/transactions', window.location.origin)
  fetchURL.searchParams.set('startDate', startDate)
  fetchURL.searchParams.set('endDate', endDate)
  const { data } = await axios.get(fetchURL.href, {
    signal
  })
  return ViaboPayLiquidatedMovementsAdapter(data)
}

export const liquidateTerminalMovement = async movement => {
  const { data } = await axios.post('/api/card/transactions/shared-terminals', movement)
  return data
}
