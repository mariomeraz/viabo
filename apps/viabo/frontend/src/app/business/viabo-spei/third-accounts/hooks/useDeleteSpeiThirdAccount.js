import { useMutation, useQueryClient } from '@tanstack/react-query'
import { toast } from 'react-toastify'

import { SPEI_THIRD_ACCOUNTS_KEYS } from '../adapters'
import { deleteSpeiThirdAccount } from '../services'

import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'
import { isFunction } from '@/shared/utils'

export const useDeleteSpeiThirdAccount = (options = {}) => {
  const client = useQueryClient()
  const speiThirdAccount = useMutation(deleteSpeiThirdAccount, options)
  const mutate = async (formData, options) => {
    const { onSuccess, onError, mutationOptions } = options

    try {
      await toast.promise(speiThirdAccount.mutateAsync(formData, mutationOptions), {
        pending: 'Dando de baja cuenta ...',
        success: {
          render({ data }) {
            client.invalidateQueries([SPEI_THIRD_ACCOUNTS_KEYS.THIRD_ACCOUNTS_LIST])
            isFunction(onSuccess) && onSuccess(data)

            return 'Se dio de baja la cuenta con éxito'
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
    ...speiThirdAccount,
    mutate
  }
}
