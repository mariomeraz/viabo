import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'

import { MANAGEMENT_STOCK_CARDS_KEYS } from '@/app/management/stock-cards/adapters'
import { getStockCards } from '@/app/management/stock-cards/services'
import { getErrorAPI } from '@/shared/interceptors'

export const useFindStockCards = (options = {}) => {
  const [customError, setCustomError] = useState(null)
  const commerces = useQuery([MANAGEMENT_STOCK_CARDS_KEYS.STOCK_CARDS_LIST], getStockCards, {
    staleTime: 60000,
    onError: error => {
      const errorMessage = getErrorAPI(
        error,
        'No se puede obtener la lista de tarjetas. Intente nuevamente o reporte a sistemas'
      )
      setCustomError(errorMessage)
    },
    ...options
  })
  return {
    ...commerces,
    error: customError || null
  }
}
