import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'
import { toast } from 'react-toastify'

import { DASHBOARD_MASTER_KEYS } from '@/app/business/dashboard-master/adapters/dashboardMasterKeys'
import { getGlobalCards } from '@/app/business/dashboard-master/services'
import { useCommerceDetailsCard } from '@/app/business/viabo-card/cards/store'
import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'

export const useFindGlobalCards = (options = {}) => {
  const [customError, setCustomError] = useState(null)
  const setMainCard = useCommerceDetailsCard(state => state.setMainCard)
  const commerces = useQuery([DASHBOARD_MASTER_KEYS.GLOBAL_CARDS], getGlobalCards, {
    staleTime: 60000,
    refetchOnWindowFocus: false,
    onError: error => {
      const errorMessage = getErrorAPI(error, 'No se puede obtener la información de las tarjetas principales')
      setCustomError(errorMessage)
      setMainCard(null)
      toast.error(errorMessage, {
        type: getNotificationTypeByErrorCode(error)
      })
    },
    onSuccess: data => {
      setMainCard(data)
    },
    ...options
  })
  return {
    ...commerces,
    error: customError || null
  }
}
