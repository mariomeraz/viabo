import { useMutation, useQueryClient } from '@tanstack/react-query'
import { toast } from 'react-toastify'

import { VIABO_SPEI_DASHBOARD_KEYS } from '../../dashboard/adapters'
import { VIABO_SPEI_SHARED_KEYS } from '../adapters'
import { createSpeiOut } from '../services'

import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'
import { isFunction } from '@/shared/utils'

export const useCreateSpeiOut = (options = {}) => {
  const client = useQueryClient()
  const transactions = useMutation(createSpeiOut, options)
  const mutate = async (formData, options) => {
    const { onSuccess, onError, mutationOptions } = options

    try {
      const data = await toast.promise(transactions.mutateAsync(formData, mutationOptions), {
        pending: 'Enviando Transacciones ...'
      })
      client.invalidateQueries([VIABO_SPEI_DASHBOARD_KEYS.ACCOUNTS_INFO])
      client.invalidateQueries([VIABO_SPEI_SHARED_KEYS.BALANCE_RESUME])
      client.invalidateQueries([VIABO_SPEI_SHARED_KEYS.MOVEMENTS])
      isFunction(onSuccess) && onSuccess(data)
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
    ...transactions,
    mutate
  }
}
