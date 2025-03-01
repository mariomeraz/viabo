import { useState } from 'react'

import { useQuery } from '@tanstack/react-query'
import { endOfDay, format, startOfDay } from 'date-fns'
import { es } from 'date-fns/locale'
import { toast } from 'react-toastify'

import { DASHBOARD_MASTER_KEYS } from '@/app/business/dashboard-master/adapters/dashboardMasterKeys'
import { getMasterMovements } from '@/app/business/dashboard-master/services'
import { useMasterGlobalStore } from '@/app/business/dashboard-master/store'
import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'

export const useFindMasterMovements = (startDate, endDate, options = {}) => {
  if (!startDate || !endDate) {
    return null
  }
  const initialDate = format(startOfDay(startDate), 'yyyy-MM-dd')
  const finalDate = format(endOfDay(endDate), 'yyyy-MM-dd')
  const [customError, setCustomError] = useState(null)
  const { setMovements, setFilterDate } = useMasterGlobalStore(state => state)

  const movements = useQuery(
    [DASHBOARD_MASTER_KEYS.MOVEMENTS],
    ({ signal }) => getMasterMovements(initialDate, finalDate, signal),
    {
      staleTime: 60000,
      retry: false,
      refetchOnWindowFocus: false,
      onError: error => {
        const errorMessage = getErrorAPI(
          error,
          'No se puede obtener la lista de movimientos. Intente nuevamente o reporte a sistemas'
        )
        setCustomError(errorMessage)
        toast.error(errorMessage, {
          type: getNotificationTypeByErrorCode(error)
        })
        setMovements(null)
      },
      onSuccess: data => {
        setFilterDate({
          startDate: startOfDay(startDate),
          endDate: endOfDay(endDate),
          text: `${format(startDate, 'dd MMMM yyyy', { locale: es })} - ${format(endDate, 'dd MMMM yyyy', {
            locale: es
          })}`
        })
      },
      ...options
    }
  )
  return {
    ...movements,
    error: customError || null
  }
}
