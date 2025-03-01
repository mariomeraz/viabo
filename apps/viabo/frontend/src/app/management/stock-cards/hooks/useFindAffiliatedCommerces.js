import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'
import { useSnackbar } from 'notistack'

import { MANAGEMENT_STOCK_CARDS_KEYS } from '@/app/management/stock-cards/adapters'
import { getAffiliatedCommerces } from '@/app/management/stock-cards/services'
import { getErrorAPI } from '@/shared/interceptors'

export const useFindAffiliatedCommerces = (options = {}) => {
  const { enqueueSnackbar } = useSnackbar()
  const [customError, setCustomError] = useState(null)
  const commerces = useQuery([MANAGEMENT_STOCK_CARDS_KEYS.AFFILIATED_COMMERCES_LIST], getAffiliatedCommerces, {
    staleTime: 60 * 5000,
    onError: error => {
      const errorMessage = getErrorAPI(error, 'No se puede obtener la lista de comercios afiliados')
      setCustomError(errorMessage)
      enqueueSnackbar(errorMessage, {
        variant: 'error',
        autoHideDuration: 5000
      })
    },
    ...options
  })
  return {
    ...commerces,
    error: customError || null
  }
}
