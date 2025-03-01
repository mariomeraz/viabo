import PropTypes from 'prop-types'

import { Stack, Typography } from '@mui/material'

import { FullLogo } from '.'

export const ViaboSpeiLogo = ({ sx, ...others }) => (
  <Stack direction={'row'} spacing={0.5} alignItems={'center'} justifyContent={'center'}>
    <FullLogo sx={{ width: 40 }} />
    <Typography variant="subtitle1" color={'primary.main'}>
      |
    </Typography>
    <Typography variant="subtitle2" color={'primary.main'}>
      spei
    </Typography>
  </Stack>
)

ViaboSpeiLogo.propTypes = {
  sx: PropTypes.any
}
