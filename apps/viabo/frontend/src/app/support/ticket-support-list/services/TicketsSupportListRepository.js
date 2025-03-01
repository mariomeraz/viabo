import { AssignedTicketsListAdapter, GeneratedTicketsListAdapter, TicketConversationAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const getGeneratedTicketsSupportList = async () => {
  const fetchURL = new URL('/api/tickets', window.location.origin)
  fetchURL.searchParams.set('created', true)

  const { data } = await axios.get(fetchURL)

  return GeneratedTicketsListAdapter(data)
}

export const getAssignedTicketsSupportList = async () => {
  const fetchURL = new URL('/api/tickets', window.location.origin)
  fetchURL.searchParams.set('assigned', true)

  const { data } = await axios.get(fetchURL)

  return AssignedTicketsListAdapter(data)
}

export const getSupportTicketConversation = async (ticketId, page) => {
  // const page = pageParam === 0 ? 1 : pageParam

  const fetchURL = new URL('/api/tickets/messages', window.location.origin)
  fetchURL.searchParams.set('ticket', ticketId)
  fetchURL.searchParams.set('limit', 10)
  fetchURL.searchParams.set('page', page)

  const { data } = await axios.get(fetchURL)
  return TicketConversationAdapter(data, page)
}

export const addMessageToSupportTicketConversation = async message => {
  const { data } = await axios.post('/api/tickets/message/new', message?.data)

  return message?.ticketId
}

export const finishSupportTicket = async ticket => {
  const { data } = await axios.put(`/api/tickets/ticket/${ticket?.ticketId}/close`)

  return data
}
