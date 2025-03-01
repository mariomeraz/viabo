import { useMutation } from '@tanstack/react-query'
import { useSnackbar } from 'notistack'

import { validateCode } from '@/app/business/shared/services'
import { getErrorAPI, getNotificationTypeByErrorCode } from '@/shared/interceptors'

export const useValidateCode = (options = {}) => {
  const { enqueueSnackbar } = useSnackbar()
  return useMutation({
    mutationFn: validateCode,
    onError: error => {
      const message = getErrorAPI(error, 'No se puede validar el código')
      enqueueSnackbar(message, {
        variant: getNotificationTypeByErrorCode(error),
        autoHideDuration: 5000
      })
    },
    ...options
  })
}
