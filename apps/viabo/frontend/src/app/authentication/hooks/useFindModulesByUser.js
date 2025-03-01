import { useQuery } from '@tanstack/react-query'

import { AUTHENTICATION_KEYS } from '@/app/authentication/adapters'
import { getUserModules } from '@/app/authentication/services'

export const UseFindModulesByUser = (options = {}) =>
  useQuery([AUTHENTICATION_KEYS.USER_MODULES], getUserModules, {
    staleTime: 60 * 5000,
    ...options
  })
