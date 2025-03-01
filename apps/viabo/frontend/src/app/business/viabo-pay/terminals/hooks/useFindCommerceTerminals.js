import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'

import { TERMINALS_KEYS } from '../adapters'
import { getCommerceTerminals } from '../services'

import { getErrorAPI } from '@/shared/interceptors'

export const useFindCommerceTerminals = (options = {}) => {
  const [customError, setCustomError] = useState(null)
  const commerces = useQuery([TERMINALS_KEYS.LIST], getCommerceTerminals, {
    staleTime: 60000,
    refetchOnMount: 'always',
    onError: error => {
      const errorMessage = getErrorAPI(
        error,
        'No se puede obtener la lista de terminales del comercio. Intente nuevamente o reporte a sistemas'
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
