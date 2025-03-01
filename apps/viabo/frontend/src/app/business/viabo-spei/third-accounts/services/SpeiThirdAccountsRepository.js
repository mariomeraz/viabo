import { SpeiBanksAdapter, SpeiThirdAccountsListAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const getSpeiThirdAccountsList = async () => {
  const { data } = await axios.get('/api/spei/external-accounts')
  return SpeiThirdAccountsListAdapter(data)
}

export const newSpeiThirdAccount = async account => {
  const { data } = await axios.post('/api/spei/external-account/new', account)
  return data
}

export const getSpeiBanks = async () => {
  const { data } = await axios.get('/api/spei/banks')
  return SpeiBanksAdapter(data)
}

export const deleteSpeiThirdAccount = async account => {
  const { data } = await axios.put('/api/spei/external-account/disable', account)
  return data
}
