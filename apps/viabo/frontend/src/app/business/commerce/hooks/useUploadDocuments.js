import { useMutation, useQueryClient } from '@tanstack/react-query'
import { useSnackbar } from 'notistack'

import { COMMERCE_KEYS } from '@/app/business/commerce/adapters'
import { uploadDocuments } from '@/app/business/commerce/services'
import { getErrorAPI } from '@/shared/interceptors'

export const useUploadDocuments = (options = {}) => {
  const { enqueueSnackbar } = useSnackbar()
  const client = useQueryClient()
  return useMutation({
    mutationFn: uploadDocuments,
    onSuccess: () => {
      client.invalidateQueries([COMMERCE_KEYS.COMMERCE_PROCESS])
      enqueueSnackbar('Se agregaron los documentos al proceso!', {
        variant: 'success'
      })
    },
    onError: error => {
      const message = getErrorAPI(error, 'No se puede agregar los doumentos al proceso')
      enqueueSnackbar(message, {
        variant: error?.status === 500 ? 'error' : 'warning',
        autoHideDuration: 5000
      })
    },
    ...options
  })
}
