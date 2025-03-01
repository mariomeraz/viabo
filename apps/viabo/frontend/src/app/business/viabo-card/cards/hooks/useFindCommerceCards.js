import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'

import { CARDS_COMMERCES_KEYS } from '@/app/business/viabo-card/cards/adapters'
import { getEnabledCommerceCards } from '@/app/business/viabo-card/cards/services'
import { getErrorAPI } from '@/shared/interceptors'

export const useFindCommerceCards = (cardTypeId, options = {}) => {
  const [customError, setCustomError] = useState(null)
  const commerces = useQuery(
    [CARDS_COMMERCES_KEYS.CARDS_COMMERCE_LIST, cardTypeId],
    () => getEnabledCommerceCards(cardTypeId),
    {
      staleTime: 60000,
      refetchOnMount: 'always',
      onError: error => {
        const errorMessage = getErrorAPI(
          error,
          'No se puede obtener la lista de tarjetas. Intente nuevamente o reporte a sistemas'
        )
        setCustomError(errorMessage)
      },
      ...options
    }
  )
  return {
    ...commerces,
    error: customError || null
  }
}
