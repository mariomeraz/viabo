import { SpeiAdminCostCenterUsersAdapter, SpeiCostCentersListAdapter } from '../adapters'

import { axios } from '@/shared/interceptors'

export const getSpeiCostCentersList = async () => {
  const { data } = await axios.get('/api/backoffice/cost-centers')
  return SpeiCostCentersListAdapter(data)
}

export const newSpeiCostCenter = async costCenter => {
  const { data } = await axios.post('/api/backoffice/cost-center/new', costCenter)
  return data
}

export const getViaboSpeiAdminCostCenterUsers = async () => {
  const { data } = await axios.get('/api/security/users/administrators-of-cost-centers')

  return SpeiAdminCostCenterUsersAdapter(data)
}

export const updateSpeiCostCenter = async costCenter => {
  const { data } = await axios.put('/api/backoffice/cost-center/update', costCenter)
  return costCenter
}
