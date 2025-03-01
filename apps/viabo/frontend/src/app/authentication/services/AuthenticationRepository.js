import { GoogleAuthQRCodeAdapter, UserModulesAdapter } from '@/app/authentication/adapters'
import { axios } from '@/shared/interceptors'

export const signIn = async user => {
  const { data } = await axios.post('/api/login', user)
  return data
}

export const logout = async () => {
  const { data } = await axios.post('/api/logout')
  return data
}

export const getUserModules = async token => {
  const { data } = await axios.get('/api/modules/user')
  return UserModulesAdapter(data)
}

export const changePassword = async password => {
  const { data } = await axios.put('/api/user/password/reset', password)
  return data
}

export const getGoogleAuthQRCode = async () => {
  const { data } = await axios.get('/api/security/google-authenticator/qr')
  return GoogleAuthQRCodeAdapter(data)
}

export const enableTwoAuth = async twoAuth => {
  const { data } = await axios.post('/api/security/google-authenticator/enable', twoAuth)
  return data
}

export const validateGoogleAuthCode = async code => {
  const { data } = await axios.post('/api/security/google-authenticator/validate', code, {
    headers: { Authorization: `Bearer ${code?.token}` }
  })
  return data
}
