import { Add } from '@mui/icons-material'
import { Box, Card, CardHeader, IconButton, Tooltip } from '@mui/material'

import { getSpeiThirdAccountsTableActions } from './SpeiThirdAccountsTableActions'

import { useFindSpeiThirdAccountsList, useSpeiThirdAccountsColumns } from '../hooks'
import { useSpeiThirdAccounts } from '../store'

import { MaterialDataTable } from '@/shared/components/dataTables'
import { useMaterialTable } from '@/shared/hooks'

export const SpeiThirdAccountsList = () => {
  const { data: thirdAccounts, isLoading, isError, error, isFetching } = useFindSpeiThirdAccountsList()

  const { setOpenNewSpeiThirdAccount } = useSpeiThirdAccounts()

  const columns = useSpeiThirdAccountsColumns()

  const table = useMaterialTable(isError, error, {
    columns,
    data: thirdAccounts || [],
    enableColumnPinning: true,
    enableColumnFilterModes: true,
    enableStickyHeader: true,
    enableRowVirtualization: true,
    enableFacetedValues: true,
    enableRowActions: true,
    enableRowSelection: true,
    enableDensityToggle: false,
    positionActionsColumn: 'last',
    selectAllMode: 'all',
    initialState: {
      density: 'compact',
      sorting: [
        {
          id: 'name',
          desc: false
        }
      ]
    },
    state: {
      isLoading,
      showAlertBanner: isError,
      showProgressBars: isFetching
    },
    displayColumnDefOptions: {
      'mrt-row-select': {
        maxSize: 10
      },
      'mrt-row-actions': {
        header: 'Acciones',
        maxSize: 80
      }
    },
    muiTableContainerProps: { sx: { maxHeight: { md: '350px', lg: '450px', xl: '700px' } } },
    enableColumnResizing: true,
    layoutMode: 'grid',
    renderTopToolbarCustomActions: () => <Box></Box>,
    renderRowActions: table => getSpeiThirdAccountsTableActions(table)
  })

  return (
    <Card
      variant="outlined"
      sx={theme =>
        !table.getState().isFullScreen
          ? {
              boxShadow: theme.customShadows.z24,
              backgroundColor: theme.palette.mode === 'light' ? 'inherit' : theme.palette.grey[500_12],
              backdropFilter: `blur(10px)`,
              WebkitBackdropFilter: `blur(10px)`
            }
          : {}
      }
    >
      <CardHeader
        sx={theme => ({
          pb: 2
        })}
        title="Lista de Cuentas"
        subheader={`Tienes ${thirdAccounts?.length || 0} cuentas dadas de alta`}
        action={
          <Tooltip title="Nueva Cuenta">
            <IconButton color="primary" size="large" onClick={() => setOpenNewSpeiThirdAccount(true)}>
              <Add />
            </IconButton>
          </Tooltip>
        }
      />
      <MaterialDataTable table={table} />
    </Card>
  )
}
