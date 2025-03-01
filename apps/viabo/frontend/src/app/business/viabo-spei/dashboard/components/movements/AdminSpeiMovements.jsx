import { useMemo } from 'react'

import PropTypes from 'prop-types'

import { Alert, Box, CardContent, CardHeader, Divider, Stack, alpha } from '@mui/material'

import { AdminSpeiLastMovements } from './AdminSpeiLastMovements'

import { getTitleAccountsByStpAccountType } from '../../constants'
import { useAdminDashboardSpeiStore } from '../../store'

import { CardViaboSpeiStyle } from '@/app/business/viabo-spei/shared/components'
import { useFindViaboSpeiMovements } from '@/app/business/viabo-spei/shared/hooks'

const AdminSpeiMovements = ({ isEmptyAccount }) => {
  const selectedAccount = useAdminDashboardSpeiStore(state => state.selectedAccount)
  const stpAccounts = useAdminDashboardSpeiStore(state => state.stpAccounts)
  const queryMovements = useFindViaboSpeiMovements(
    { limit: 10, account: selectedAccount?.account?.number },
    { enabled: !!selectedAccount?.account?.number }
  )
  const { isLoading, data: movements } = queryMovements
  const title = useMemo(() => getTitleAccountsByStpAccountType(stpAccounts?.type), [stpAccounts])

  return (
    <Box
      component={CardViaboSpeiStyle}
      variant="outlined"
      sx={theme => ({
        backdropFilter: `blur(10px)`,
        WebkitBackdropFilter: `blur(10px)`
      })}
    >
      <CardHeader sx={{ p: 2 }} title="Últimas transacciones" />
      <Divider sx={{ borderColor: alpha('#CFDBD5', 0.7) }} />
      <CardContent sx={{ p: 0 }}>
        {isEmptyAccount ? (
          <Stack pt={3} px={3}>
            <Alert severity="info">No tienes {title} asignados</Alert>
          </Stack>
        ) : (
          <Stack flexDirection={'row'} sx={{ height: '100%', display: 'flex', flexGrow: 1 }}>
            <AdminSpeiLastMovements movementsGrouped={movements?.groupByDay} isLoading={isLoading} />
          </Stack>
        )}
      </CardContent>
    </Box>
  )
}

AdminSpeiMovements.propTypes = {
  isEmptyAccount: PropTypes.any
}

export default AdminSpeiMovements
