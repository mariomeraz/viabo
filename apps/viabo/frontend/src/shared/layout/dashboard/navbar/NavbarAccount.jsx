import PropTypes from 'prop-types'

import { Box, Typography } from '@mui/material'
import { styled } from '@mui/material/styles'

import { useAuth } from '@/shared/hooks'
import { MyAvatar } from '@/shared/layout/dashboard/header'

const RootStyle = styled('div')(({ theme }) => ({
  display: 'flex',
  alignItems: 'center',
  padding: theme.spacing(2, 2.5),
  borderRadius: Number(theme.shape.borderRadius) * 1.5,
  backgroundColor: theme.palette.grey[500_12],
  transition: theme.transitions.create('opacity', {
    duration: theme.transitions.duration.shorter
  })
}))

NavbarAccount.propTypes = {
  isCollapse: PropTypes.bool
}

export default function NavbarAccount({ isCollapse }) {
  const { user } = useAuth()
  return (
    <RootStyle
      sx={{
        ...(isCollapse && {
          bgcolor: 'transparent'
        })
      }}
    >
      <MyAvatar />

      <Box
        sx={{
          ml: 2,
          transition: theme =>
            theme.transitions.create('width', {
              duration: theme.transitions.duration.shorter
            }),
          ...(isCollapse && {
            ml: 0,
            width: 0
          })
        }}
      >
        <Typography variant="subtitle2" textTransform={'capitalize'}>
          {user?.name}
        </Typography>
        <Typography variant="body2" textTransform={'capitalize'} sx={{ color: 'text.secondary' }}>
          {user?.profile}
        </Typography>
      </Box>
    </RootStyle>
  )
}
