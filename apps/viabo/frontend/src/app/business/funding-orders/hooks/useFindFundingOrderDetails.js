import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'
import { toast } from 'react-toastify'

import { FUNDING_ORDERS_KEYS } from '../adapters'
import { getFundingOrderDetails } from '../services'

import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'

export const useFindFundingOrderDetails = (fundingOrder, options = {}) => {
  const [customError, setCustomError] = useState(null)

  const fundingOrderDetails = useQuery(
    [FUNDING_ORDERS_KEYS.DETAILS, fundingOrder?.id],
    () => getFundingOrderDetails(fundingOrder),
    {
      staleTime: 60000,
      refetchOnWindowFocus: false,
      onError: error => {
        const errorMessage = getErrorAPI(error, 'No se puede obtener la información de la orden de fondeo')
        setCustomError(errorMessage)
        toast.error(errorMessage, {
          type: getNotificationTypeByErrorCode(error)
        })
      },
      ...options
    }
  )
  return {
    ...fundingOrderDetails,
    error: customError || null
  }
}
