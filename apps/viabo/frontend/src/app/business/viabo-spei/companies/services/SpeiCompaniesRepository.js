import {
  SpeiAdminCompanyUsersAdapter,
  SpeiCompaniesListAdapter,
  SpeiCompanyDetailsAdapter,
  SpeiConcentratorListAdapter
} from '../adapters'

import { axios } from '@/shared/interceptors'

export const getSpeiCompaniesList = async () => {
  const { data } = await axios.get('/api/commerces')
  return SpeiCompaniesListAdapter(data)
}

export const newSpeiCompany = async company => {
  const { data } = await axios.post('/api/backoffice/company/new', company)
  return data
}

export const getViaboSpeiAdminCompanyUsers = async () => {
  const { data } = await axios.get('/api/security/users/administrators-of-companies')

  return SpeiAdminCompanyUsersAdapter(data)
}

export const changeSpeiCompanyStatus = async company => {
  const fetchURL = new URL('/api/backoffice/company/toggle', window.location.origin)

  fetchURL.searchParams.set('company', company?.id)
  fetchURL.searchParams.set('active', company?.changeStatus)

  const { data } = await axios.put(fetchURL)

  return company
}

export const getViaboSpeiCompanyDetails = async companyId => {
  const { data } = await axios.get(`/api/backoffice/company/${companyId}`)

  return SpeiCompanyDetailsAdapter(data)
}

export const updateViaboSpeiCompany = async company => {
  const { data } = await axios.put('/api/backoffice/company/update', company)

  return company
}

export const getViaboSpeiConcentratorsList = async () => {
  const { data } = await axios.get('/api/spei/concentrator')

  return SpeiConcentratorListAdapter(data)
}

export const getViaboSpeiCommissions = async () => {
  const { data } = await axios.get('/api/backoffice/rates')

  return {
    percentage: data?.CommisionPercentage,
    amount: data?.FeeStp
  }
}
