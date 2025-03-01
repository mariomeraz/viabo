import { CardsPaginatedAdapter } from '@/app/shared/adapters'
import { axios } from '@/shared/interceptors'

export const getCommerceCards = async (filters, signal) => {
  const { columnFilters, globalFilter, pageIndex, pageSize, sorting } = filters

  const fetchURL = new URL('/api/cards/commerce', window.location.origin)
  fetchURL.searchParams.set('start', `${pageIndex * pageSize}`)
  fetchURL.searchParams.set('size', `${pageSize}`)
  fetchURL.searchParams.set('filters', JSON.stringify(columnFilters ?? []))
  fetchURL.searchParams.set('globalFilter', globalFilter ?? '')
  fetchURL.searchParams.set('sorting', JSON.stringify(sorting ?? []))

  const { data } = await axios.get(fetchURL.href, {
    signal
  })
  return CardsPaginatedAdapter(data)
}

export const assignCards = async cards => {
  const { data } = await axios.put('/api/assign/commerce-card/to/user', cards)
  return cards
}

export const updateUserInfo = async userInfo => {
  const { data } = await axios.put('/api/card-owner/data/update', userInfo)
  return data
}

export const recoveryPasswordAssignedUser = async user => {
  const { data } = await axios.put(`/api/card-owner/password/reset/${user.id}`)
  return data
}
