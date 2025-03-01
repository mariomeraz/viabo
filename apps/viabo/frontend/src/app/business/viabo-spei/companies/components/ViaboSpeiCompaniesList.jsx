import { useState } from 'react'

import { Add, ToggleOffTwoTone, ToggleOnTwoTone } from '@mui/icons-material'
import { Box, Card, CardHeader, IconButton, Stack, Tooltip, Typography } from '@mui/material'

import { ViaboSpeiCompaniesTableActions } from './ViaboSpeiCompaniesTableActions'

import { useChangeSpeiCompanyStatus, useSpeiCompaniesTableColumns } from '../hooks'
import { useFindSpeiCompanies } from '../hooks/useFindSpeiCompanies'
import { useSpeiCompaniesStore } from '../store'

import { MaterialDataTable } from '@/shared/components/dataTables'
import { ModalAlert } from '@/shared/components/modals'
import { useMaterialTable } from '@/shared/hooks'

export const ViaboSpeiCompaniesList = () => {
  const { data: companies, isLoading, isError, error, isFetching } = useFindSpeiCompanies()

  const { setOpenNewSpeiCompany } = useSpeiCompaniesStore()

  const columns = useSpeiCompaniesTableColumns()

  const [openConfirmation, setOpenConfirmation] = useState(false)
  const [causeIdToggleStatus, setCauseIdToggleStatus] = useState(null)
  const [companyData, setCompanyData] = useState(null)
  const { mutate: toggleStatus, isLoading: isChangingCauseStatus } = useChangeSpeiCompanyStatus()

  const handleSuccessChangeStatus = () => {
    setOpenConfirmation(false)
    toggleStatus(
      { ...companyData, changeStatus: !companyData?.status },
      {
        onSuccess: () => {
          setCauseIdToggleStatus(null)
          setCompanyData(null)
        },
        onError: () => {
          setCauseIdToggleStatus(null)
          setCompanyData(null)
        }
      }
    )
  }

  const table = useMaterialTable(isError, error, {
    columns,
    data: companies || [],
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
          id: 'folio',
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
    muiTableBodyRowProps: ({ row }) => ({
      sx: theme => ({
        backgroundColor: 'inherit',
        '&.Mui-selected': {
          backgroundColor: theme.palette.action.selected,
          '&:hover': {
            backgroundColor: theme.palette.action.hover
          }
        }
      })
    }),
    enableColumnResizing: true,
    layoutMode: 'grid',
    renderTopToolbarCustomActions: () => <Box></Box>,
    renderRowActions: table => (
      <ViaboSpeiCompaniesTableActions
        table={table}
        isChangingCauseStatus={isChangingCauseStatus}
        onChangeStatus={rowData => {
          setCompanyData(rowData)
          setCauseIdToggleStatus(rowData?.id)
          setOpenConfirmation(true)
        }}
        causeIdToggleStatus={causeIdToggleStatus}
      />
    )
  })

  return (
    <>
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
          title="Lista de Empresas"
          subheader={`Tienes ${companies?.length || 0} empresas dadas de alta`}
          action={
            <Tooltip title="Nueva Empresa">
              <IconButton color="primary" size="large" onClick={() => setOpenNewSpeiCompany(true)}>
                <Add />
              </IconButton>
            </Tooltip>
          }
        />
        <MaterialDataTable table={table} />
      </Card>
      <ModalAlert
        title={
          <Stack alignItems={'center'} justifyContent={'space-between'} flexDirection={'row'}>
            <Typography variant="h6">{companyData?.status ? 'Desactivar Empresa' : 'Activar Empresa'}</Typography>
            {companyData?.status ? <ToggleOffTwoTone color="error" /> : <ToggleOnTwoTone color="success" />}
          </Stack>
        }
        textButtonSuccess="Si"
        textButtonCancel="No"
        onClose={() => {
          setOpenConfirmation(false)
        }}
        open={openConfirmation}
        actionsProps={{ sx: { justifyContent: 'center' } }}
        description={
          <Stack spacing={3}>
            <Stack spacing={0.5} p={2} borderColor={'secondary.light'} borderRadius={2} sx={{ borderStyle: 'dotted' }}>
              <Typography fontWeight={'bold'} variant="subtitle2">
                {companyData?.name}
              </Typography>
              <Typography variant="subtitle2">{companyData?.rfc}</Typography>
              <Typography variant="subtitle2">{companyData?.stpAccount?.hidden}</Typography>
            </Stack>

            <Typography textAlign={'center'}>
              ¿Está seguro de{' '}
              <Box component={'span'} sx={{ fontWeight: 'bold' }}>{`${
                companyData?.status ? 'Desactivar' : 'Activar'
              }`}</Box>{' '}
              la empresa?
            </Typography>
          </Stack>
        }
        onSuccess={handleSuccessChangeStatus}
        fullWidth
        maxWidth="xs"
      />
    </>
  )
}
