import { NewsAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const getNewsSystem = async () => {
  const { data } = await axios.get(`/api/news`)
  return NewsAdapter(data)
}
