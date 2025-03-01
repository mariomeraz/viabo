import { useEffect, useMemo } from 'react'

import PropTypes from 'prop-types'

import {
  Alert,
  Autocomplete,
  Box,
  CardContent,
  CardHeader,
  Divider,
  Stack,
  TextField,
  Typography,
  alpha,
  useTheme
} from '@mui/material'

import { STP_ACCOUNT_TYPES, getTitleAccountsByStpAccountType } from '../../constants'
import { useAdminDashboardSpeiStore } from '../../store'
import { AdminSpeiCardAccount } from '../balance/AdminsSpeiCardAccount'

import {
  ButtonViaboSpei,
  CardViaboSpeiStyle,
  borderColorViaboSpeiStyle
} from '@/app/business/viabo-spei/shared/components'
import { CircularLoading } from '@/shared/components/loadings'

export const AdminSpeiAccounts = ({ isEmptyAccount, isLoading }) => {
  const theme = useTheme()
  const { setOpenSpeiOut, setOpenTransactions, stpAccounts, selectedAccount, setSelectedAccount } =
    useAdminDashboardSpeiStore()
  const setCompanies = useAdminDashboardSpeiStore(state => state.setCompanies)

  const title = useMemo(() => getTitleAccountsByStpAccountType(stpAccounts?.type), [stpAccounts])

  const handleChangeCompany = (e, newValue) => {
    setSelectedAccount(newValue)
  }

  const options = useMemo(() => {
    if (stpAccounts?.type === STP_ACCOUNT_TYPES.CONCENTRATOR) {
      return stpAccounts?.accounts || []
    }

    if (stpAccounts?.type === STP_ACCOUNT_TYPES.COST_CENTER) {
      return selectedAccount?.companies || []
    }
    return stpAccounts?.accounts || []
  }, [stpAccounts, selectedAccount])

  useEffect(() => {
    if (stpAccounts?.type === STP_ACCOUNT_TYPES.CONCENTRATOR) {
      return setCompanies(selectedAccount?.companies || [])
    }

    if (stpAccounts?.type === STP_ACCOUNT_TYPES.COST_CENTER) {
      return setCompanies(selectedAccount?.companies || [])
    }

    return setCompanies(stpAccounts?.accounts?.filter(account => account?.id !== selectedAccount?.id) || [])
  }, [stpAccounts, selectedAccount])

  return (
    <Box display={'flex'} component={CardViaboSpeiStyle} variant="outlined" flexDirection={'column'}>
      <CardHeader
        sx={{ p: 2 }}
        title={
          <Stack flexDirection={'row'} justifyContent={'space-between'} alignItems={'center'}>
            <Box sx={{ flexGrow: 1 }}>
              <Typography variant={'h6'}>{title}</Typography>
            </Box>
            {stpAccounts?.accounts?.length > 1 && (
              <Stack flexGrow={1}>
                <Autocomplete
                  disableClearable
                  options={options || []}
                  fullWidth
                  size="small"
                  value={selectedAccount}
                  onChange={handleChangeCompany}
                  getOptionLabel={option => option?.label || ''}
                  getOptionDisabled={option => option?.isDisabled}
                  isOptionEqualToValue={(option, current) => option?.value === current?.value}
                  renderInput={params => (
                    <TextField
                      {...params}
                      label={title}
                      placeholder="Seleccionar"
                      InputProps={{
                        ...params.InputProps,
                        sx: {
                          borderRadius: theme => Number(1),
                          borderColor: borderColorViaboSpeiStyle
                        }
                      }}
                    />
                  )}
                />
              </Stack>
            )}
          </Stack>
        }
      />
      <Divider sx={{ borderColor: alpha('#CFDBD5', 0.7) }} />
      <CardContent sx={{ p: 4, display: 'flex', flexDirection: 'column', gap: 2 }}>
        {isLoading && (
          <Stack justifyContent={'center'} alignItems={'center'}>
            <CircularLoading />
          </Stack>
        )}
        {isEmptyAccount && !isLoading && <Alert severity="info">No tienes {title} asignados</Alert>}
        {!isEmptyAccount && !isLoading && (
          <>
            <Box mb={2}>
              <AdminSpeiCardAccount stpAccount={selectedAccount} />
            </Box>
            <ButtonViaboSpei
              size="large"
              variant="outlined"
              sx={{ color: 'text.primary' }}
              onClick={() => setOpenSpeiOut(true)}
              startIcon={
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  viewBox="0 0 24 24"
                  stroke={theme.palette.text.primary}
                  strokeWidth={2}
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  fill="none"
                >
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M12 19h-6a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
                  <path d="M3 10h18" />
                  <path d="M16 19h6" />
                  <path d="M19 16l3 3l-3 3" />
                  <path d="M7.005 15h.005" />
                  <path d="M11 15h2" />
                </svg>
              }
            >
              SPEI OUT
            </ButtonViaboSpei>
            <ButtonViaboSpei
              size="large"
              variant="outlined"
              sx={{ color: 'text.primary' }}
              onClick={() => setOpenTransactions(true)}
              startIcon={
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  viewBox="0 0 24 24"
                  strokeWidth="1.5"
                  stroke={theme.palette.text.primary}
                  fill="none"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                >
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                  <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                  <path d="M9 17v-5" />
                  <path d="M12 17v-1" />
                  <path d="M15 17v-3" />
                </svg>
              }
            >
              Detalles Movimientos
            </ButtonViaboSpei>
          </>
        )}
      </CardContent>
    </Box>
  )
}

AdminSpeiAccounts.propTypes = {
  isEmptyAccount: PropTypes.any,
  isLoading: PropTypes.any
}
