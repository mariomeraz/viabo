import { useQuery, useQueryClient } from '@tanstack/react-query'
import { useSnackbar } from 'notistack'

import { COMMERCE_KEYS } from '@/app/business/commerce/adapters'
import { getCommerceToken } from '@/app/business/commerce/services'
import { getErrorAPI } from '@/shared/interceptors'

export const useFindCommerceToken = (email, options = {}) => {
  const { enqueueSnackbar } = useSnackbar()
  const client = useQueryClient()
  return useQuery([COMMERCE_KEYS.TOKEN_COMMERCE], () => getCommerceToken(email), {
    staleTime: 60 * 5000,
    onSuccess: () => {
      client.removeQueries([COMMERCE_KEYS.COMMERCE_PROCESS])
    },
    onError: error => {
      const errorMessage = getErrorAPI(error, '😟 Error al obtener el comercio')
      enqueueSnackbar(errorMessage, {
        variant: 'error',
        autoHideDuration: 5000
      })
    },
    ...options
  })
}
