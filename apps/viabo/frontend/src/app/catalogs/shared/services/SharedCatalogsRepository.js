import { ProfilesAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const getProfilesCatalog = async () => {
  const { data } = await axios.get('/api/profiles')

  return ProfilesAdapter(data)
}
