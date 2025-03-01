import { AffiliatedCommercesAdapter } from '@/app/management/stock-cards/adapters'
import { CardsAdapter } from '@/app/shared/adapters'
import { axios } from '@/shared/interceptors'

export const createNewStockCard = async card => {
  const { data } = await axios.post('/api/card/new', card)
  return card
}

export const getAffiliatedCommerces = async () => {
  const { data } = await axios.get(`/api/commerces/affiliates`)
  return AffiliatedCommercesAdapter(data)
}

export const getStockCards = async () => {
  const { data } = await axios.get('/api/cards/stock')
  return CardsAdapter(data)
}

export const assignCards = async cards => {
  const url = cards?.cardId ? '/api/card/assign/commerce' : '/api/cards/assign/commerce'
  const { data } = await axios.post(url, cards)
  return data
}
