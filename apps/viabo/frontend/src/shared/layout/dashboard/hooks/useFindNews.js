import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'
import { toast } from 'react-toastify'

import { getNewsSystem } from '../services'

import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'

export const useFindNews = (options = {}) => {
  const [customError, setCustomError] = useState(null)

  const query = useQuery(['news'], getNewsSystem, {
    staleTime: 30000,
    refetchOnWindowFocus: true,
    onError: error => {
      const errorMessage = getErrorAPI(error, 'No se puede obtener la información de las noticias del sistema')
      setCustomError(errorMessage)
      toast.error(errorMessage, {
        type: getNotificationTypeByErrorCode(error)
      })
    },
    ...options
  })
  return {
    ...query,
    error: customError || null
  }
}
