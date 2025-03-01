import { useMutation, useQueryClient } from '@tanstack/react-query'
import { toast } from 'react-toastify'

import { SPEI_COST_CENTERS_KEYS } from '../adapters'
import { newSpeiCostCenter } from '../services'

import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'
import { isFunction } from '@/shared/utils'

export const useCreateNewSpeiCostCenter = (options = {}) => {
  const client = useQueryClient()
  const costCenter = useMutation(newSpeiCostCenter, options)
  const mutate = async (formData, options) => {
    const { onSuccess, onError, mutationOptions } = options

    try {
      await toast.promise(costCenter.mutateAsync(formData, mutationOptions), {
        pending: 'Creando centro de costos...',
        success: {
          render({ data }) {
            client.invalidateQueries([SPEI_COST_CENTERS_KEYS.COST_CENTERS_LIST])
            isFunction(onSuccess) && onSuccess(data)

            return 'Se creó el centro de costos con éxito'
          }
        }
      })
    } catch (error) {
      const errorFormatted = getErrorAPI(
        error,
        `No se puede realizar esta operación en este momento. Intente nuevamente o reporte a sistemas`
      )
      isFunction(onError) && onError(errorFormatted)
      toast.error(errorFormatted, {
        type: getNotificationTypeByErrorCode(error)
      })
    }
  }

  return {
    ...costCenter,
    mutate
  }
}
