import { createContext, useEffect, useMemo, useReducer } from 'react'

import PropTypes from 'prop-types'

import { jwtDecode } from 'jwt-decode'

import { UseFindModulesByUser } from '@/app/authentication/hooks'
import { resetAllStores } from '@/app/shared/store'
import { axios } from '@/shared/interceptors'
import { isValidToken, setSession } from '@/shared/utils'

const initialState = {
  isAuthenticated: false,
  isInitialized: false,
  isFetchingModules: false,
  user: null
}

const handlers = {
  INITIALIZE: (state, action) => {
    const { isAuthenticated, user } = action.payload
    return {
      ...state,
      isAuthenticated,
      isInitialized: true,
      user
    }
  },
  LOADING: (state, action) => ({
    ...state,
    isFetchingModules: action.payload
  }),
  LOGIN: (state, action) => {
    const { user } = action.payload

    return {
      ...state,
      isAuthenticated: true,
      isFetchingModules: false,
      user
    }
  },
  LOGOUT: state => ({
    ...state,
    isAuthenticated: false,
    isFetchingModules: false,
    user: null
  }),
  TWO_AUTH: (state, action) => ({
    ...state,
    user: {
      ...state.user,
      twoAuth: Boolean(action.payload)
    }
  })
}

const reducer = (state, action) => (handlers[action.type] ? handlers[action.type](state, action) : state)

const AuthContext = createContext({
  ...initialState,
  method: 'jwt',
  login: () => Promise.resolve(),
  logout: () => Promise.resolve(),
  setTwoAuth: () => Promise.resolve(),
  dispatch: () => {},
  state: initialState
})

AuthProvider.propTypes = {
  children: PropTypes.node
}

function AuthProvider({ children }) {
  const [state, dispatch] = useReducer(reducer, initialState)

  const {
    data: userModules,
    error,
    remove,
    isLoading
  } = UseFindModulesByUser({
    staleTime: 60 * 15000, // 15 minutos
    // cacheTime: 60 * 15000,
    refetchInterval: 60 * 15000, // 15 minutos,
    enabled: !!state.isAuthenticated
  })

  axios.interceptors.response.use(
    response => response,
    error => {
      if (error?.response?.status === 401) {
        logout(true)
      }
      return Promise.reject(error)
    }
  )

  useEffect(() => {
    if (error && state.isAuthenticated) {
      logout(true)
    }
  }, [error, state.isAuthenticated])

  useEffect(() => {
    if (userModules && state.isAuthenticated) {
      dispatch({
        type: 'INITIALIZE',
        payload: {
          isAuthenticated: true,
          user: {
            ...state.user,
            ...userModules
          }
        }
      })
    }
    dispatch({
      type: 'LOADING',
      payload: false
    })
  }, [userModules])

  useEffect(() => {
    dispatch({
      type: 'LOADING',
      payload: false
    })
    const initialize = async () => {
      try {
        const accessToken = localStorage.getItem('accessToken')
        if (accessToken && isValidToken(accessToken)) {
          setSession(accessToken)
          const decoded = jwtDecode(accessToken)
          dispatch({
            type: 'INITIALIZE',
            payload: {
              isAuthenticated: true,
              user: {
                ...state.user,
                name: decoded?.name,
                profile: decoded?.profile,
                email: decoded?.email,
                urlInit: decoded?.urlInit ?? '',
                twoAuth: decoded?.authenticatorFactors || false,
                ...userModules
              }
            }
          })
          if (isLoading) {
            dispatch({
              type: 'LOADING',
              payload: true
            })
          }
        } else {
          dispatch({
            type: 'INITIALIZE',
            payload: {
              isAuthenticated: false,
              user: null
            }
          })
          dispatch({
            type: 'LOADING',
            payload: false
          })
        }
      } catch (err) {
        console.error(err)
        dispatch({
          type: 'LOADING',
          payload: false
        })
        dispatch({
          type: 'INITIALIZE',
          payload: {
            isAuthenticated: false,
            user: null
          }
        })
      }
    }

    initialize()
  }, [isLoading])

  const logout = async (auto = false) => {
    dispatch({ type: 'LOGOUT' })
    if (!auto) {
      resetAllStores()
    }
    setSession(null)
  }

  const login = async () => {
    const accessToken = localStorage.getItem('accessToken')

    const decoded = jwtDecode(accessToken)

    dispatch({
      type: 'LOGIN',
      payload: {
        user: {
          ...state.user,
          name: decoded?.name,
          profile: decoded?.profile,
          email: decoded?.email,
          urlInit: decoded?.urlInit ?? '',
          twoAuth: decoded?.authenticatorFactors || false
        }
      }
    })
  }

  const setTwoAuth = async isEnable => {
    dispatch({
      type: 'TWO_AUTH',
      payload: isEnable
    })
  }
  const values = useMemo(
    () => ({
      ...state,
      method: 'jwt',
      logout,
      login,
      setTwoAuth,
      dispatch
    }),
    [state]
  )

  return <AuthContext.Provider value={values}>{children}</AuthContext.Provider>
}

export { AuthContext, AuthProvider }
