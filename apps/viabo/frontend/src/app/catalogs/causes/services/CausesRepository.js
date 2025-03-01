import { CausesListAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const newCause = async cause => {
  const { data } = await axios.post('/api/support-reason/new', cause)

  return data
}

export const getCausesList = async () => {
  const { data } = await axios.get('/api/tickets/support-reasons')

  return CausesListAdapter(data)
}

export const changeStatusCause = async cause => {
  const { data } = await axios.put(
    `/api/tickets/support-reasons/${cause?.id}/${cause?.changeStatus ? 'disable' : 'enable'}`
  )
  return cause
}

export const updateCause = async cause => {
  const { data } = await axios.put('/api/support-reason/update', cause)

  return data
}
