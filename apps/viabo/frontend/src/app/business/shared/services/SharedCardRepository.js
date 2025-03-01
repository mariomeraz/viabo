import { axios } from '@/shared/interceptors'

export const verifyExpenses = async expenses => {
  const { data } = await axios.post('/api/card/add/receipt', expenses)
  return data
}
