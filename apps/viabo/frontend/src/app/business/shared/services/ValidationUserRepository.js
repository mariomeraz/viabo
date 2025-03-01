import { axios } from '@/shared/interceptors'

export const sendValidationCode = async () => {
  const { data } = await axios.post('/api/code/verification/resend')
  return data
}

export const validateCode = async validationCode => {
  const { data } = await axios.post('/api/code/verificate', validationCode)
  return data
}
