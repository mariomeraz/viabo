import PropTypes from 'prop-types'

import { Add } from '@mui/icons-material'
import { LoadingButton } from '@mui/lab'
import { Box, Button, Typography } from '@mui/material'
import { Link as RouterLink } from 'react-router-dom'

import { SimpleBreadcrumbs } from '@/shared/components/breadcrumbs'

HeaderPage.propTypes = {
  onClick: PropTypes.func,
  name: PropTypes.string.isRequired,
  buttonName: PropTypes.string,
  to: PropTypes.string,
  loading: PropTypes.bool,
  buttons: PropTypes.object
}

export function HeaderPage({ name, buttonName, to = '', onClick, loading = false, buttons, links = [] }) {
  return (
    <Box display="flex" mb={2} spacing={3} flexDirection={{ xs: 'column', sm: 'row' }} alignItems={{ sm: 'center' }}>
      <Box sx={{ flexGrow: 1, mb: { xs: buttonName ? 3 : 0, sm: 0 } }}>
        <Typography variant="h4">{name}</Typography>
        <SimpleBreadcrumbs links={links} />
      </Box>
      <Box sx={{ flex: '1 1 auto' }} />

      {buttons}

      {buttonName && (
        <>
          {to === '' ? (
            <LoadingButton loading={loading} variant="contained" onClick={onClick} startIcon={<Add />}>
              {buttonName}
            </LoadingButton>
          ) : (
            <Button variant="contained" component={RouterLink} to={to} startIcon={<Add />}>
              {buttonName}
            </Button>
          )}
        </>
      )}
    </Box>
  )
}
