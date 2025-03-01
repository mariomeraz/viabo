import { ViaboSpeiAccountsAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const getAccountInfoViaboSpei = async () => {
  const { data } = await axios.get('/api/spei/accounts')

  return ViaboSpeiAccountsAdapter(data)
}
