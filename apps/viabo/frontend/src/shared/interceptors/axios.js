import axios from 'axios'

import { isHTML } from '@/shared/utils'

const axiosInstance = axios.create({
  // baseURL: '/'
})

axiosInstance.interceptors.response.use(
  response => response,
  error => Promise.reject(error)
)

export const getErrorAPI = (error, errorMessage = '') =>
  error?.response?.data && !isHTML(error?.response?.data) && error?.response?.status !== 406
    ? error?.response?.data
    : errorMessage

export default axiosInstance
