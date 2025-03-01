import { useMutation, useQueryClient } from '@tanstack/react-query'
import { toast } from 'react-toastify'

import { FUNDING_ORDERS_KEYS } from '../adapters'
import { conciliateFundingOrder } from '../services'

import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'

export const useConciliateFundingOrder = (options = {}) => {
  const client = useQueryClient()
  const conciliateOrder = useMutation(conciliateFundingOrder, options)
  const conciliate = async (formData, options) => {
    const { onSuccess, onError, mutationOptions } = options

    try {
      await toast.promise(conciliateOrder.mutateAsync(formData, mutationOptions), {
        pending: 'Conciliando orden de fondeo ...',
        success: {
          render({ data }) {
            client.invalidateQueries([FUNDING_ORDERS_KEYS.LIST])
            onSuccess(data)
            return 'Se creó la conciliación con éxito'
          }
        }
      })
    } catch (error) {
      const errorFormatted = getErrorAPI(
        error,
        `No se puede realizar esta operación en este momento. Intente nuevamente o reporte a sistemas`
      )
      onError(errorFormatted)
      toast.error(errorFormatted, {
        type: getNotificationTypeByErrorCode(error)
      })
    }
  }

  return {
    ...conciliateOrder,
    mutate: conciliate
  }
}
