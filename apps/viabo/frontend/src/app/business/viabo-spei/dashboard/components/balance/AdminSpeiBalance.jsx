import PropTypes from 'prop-types'

import { NorthEast, SouthWest } from '@mui/icons-material'
import { Grid, Stack } from '@mui/material'

import { AdminSpeiBalanceCard } from './AdminSpeiBalanceCard'
import { AdminSpeiFilterBalance } from './AdminSpeiFilterBalance'

import { AdminSpeiAccounts } from '../accounts/AdminSpeiAccounts'

import { useAdminDashboardSpeiStore } from '@/app/business/viabo-spei/dashboard/store'

const AdminSpeiBalance = ({ isEmptyAccount, isLoading }) => {
  const balance = useAdminDashboardSpeiStore(state => state.balanceResume)

  return (
    <Stack gap={3}>
      <AdminSpeiFilterBalance />
      <Grid container spacing={3}>
        <Grid item xs={12} md={6}>
          <AdminSpeiBalanceCard
            title={'Depósitos'}
            value={balance?.deposits?.currency || '$0.00'}
            transactions={balance?.deposits?.count || 0}
            icon={<SouthWest color="success" />}
          />
        </Grid>
        <Grid item xs={12} md={6}>
          <AdminSpeiBalanceCard
            title={'Transferencias'}
            value={balance?.transfers?.currency || '$0.00'}
            transactions={balance?.transfers?.count || 0}
            icon={<NorthEast color="error" />}
          />
        </Grid>
      </Grid>

      <AdminSpeiAccounts isEmptyAccount={isEmptyAccount} isLoading={isLoading} />
    </Stack>
  )
}

AdminSpeiBalance.propTypes = {
  isEmptyAccount: PropTypes.any,
  isLoading: PropTypes.any
}
export default AdminSpeiBalance
