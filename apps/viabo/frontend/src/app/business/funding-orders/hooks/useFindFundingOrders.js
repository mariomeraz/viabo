import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'
import { toast } from 'react-toastify'

import { FUNDING_ORDERS_KEYS } from '../adapters'
import { getFundingOrders } from '../services'

import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'

export const useFindFundingOrders = (options = {}) => {
  const [customError, setCustomError] = useState(null)

  const fundingOrders = useQuery([FUNDING_ORDERS_KEYS.LIST], getFundingOrders, {
    staleTime: 60000,
    refetchOnWindowFocus: false,
    onError: error => {
      const errorMessage = getErrorAPI(error, 'No se puede obtener las ordenes de fondeo')
      setCustomError(errorMessage)
      toast.error(errorMessage, {
        type: getNotificationTypeByErrorCode(error)
      })
    },
    ...options
  })
  return {
    ...fundingOrders,
    error: customError || null
  }
}
