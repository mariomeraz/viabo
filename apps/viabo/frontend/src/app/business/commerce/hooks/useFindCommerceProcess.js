import { useQuery } from '@tanstack/react-query'
import { useSnackbar } from 'notistack'

import { COMMERCE_KEYS } from '@/app/business/commerce/adapters'
import { getCommerceProcess } from '@/app/business/commerce/services'
import { getErrorAPI } from '@/shared/interceptors'

export const useFindCommerceProcess = (options = {}) => {
  const { enqueueSnackbar } = useSnackbar()
  return useQuery([COMMERCE_KEYS.COMMERCE_PROCESS], getCommerceProcess, {
    staleTime: 60 * 5000,
    onError: error => {
      const errorMessage = getErrorAPI(error, '😟 Error al obtener el proceso del comercio')
      enqueueSnackbar(errorMessage, {
        variant: 'error',
        autoHideDuration: 5000
      })
    },
    ...options
  })
}
