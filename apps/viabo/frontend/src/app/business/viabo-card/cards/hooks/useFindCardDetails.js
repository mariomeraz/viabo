import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'

import { CARDS_COMMERCES_KEYS } from '@/app/business/viabo-card/cards/adapters'
import { getCardInfo } from '@/app/business/viabo-card/cards/services'
import { getErrorAPI } from '@/shared/interceptors'

export const useFindCardDetails = (cardId, options = {}) => {
  const [customError, setCustomError] = useState(null)
  const commerces = useQuery([CARDS_COMMERCES_KEYS.CARD_INFO, cardId], ({ signal }) => getCardInfo(cardId, signal), {
    staleTime: 60000,
    onError: error => {
      const errorMessage = getErrorAPI(
        error,
        'No se puede obtener la informacion de la tarjeta. Intente nuevamente o reporte a sistemas'
      )
      setCustomError(errorMessage)
    },
    refetchOnWindowFocus: false,
    ...options
  })
  return {
    ...commerces,
    error: customError || null
  }
}
