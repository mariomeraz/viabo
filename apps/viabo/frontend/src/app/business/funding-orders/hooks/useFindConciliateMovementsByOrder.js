import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'
import { toast } from 'react-toastify'

import { FUNDING_ORDERS_KEYS } from '../adapters'
import { getMovementsByFundingOrder } from '../services'

import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'

export const useFindConciliateMovementsByOrder = (order, options = {}) => {
  const [customError, setCustomError] = useState(null)

  const fundingOrders = useQuery([FUNDING_ORDERS_KEYS.MOVEMENTS, order?.id], () => getMovementsByFundingOrder(order), {
    staleTime: 60000,
    refetchOnWindowFocus: false,
    onError: error => {
      const errorMessage = getErrorAPI(error, 'No se puede obtener los movimientos de la cuenta')
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
