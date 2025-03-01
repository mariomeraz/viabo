import { TicketCausesByProfileAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const newTicketSupport = async ticket => {
  const { data } = await axios.post('/api/tickets/ticket/new', ticket)
  return data
}

export const getTicketCausesByProfile = async () => {
  const { data } = await axios.get('/api/tickets/applicant-profile/support-reasons')
  return TicketCausesByProfileAdapter(data)
}
