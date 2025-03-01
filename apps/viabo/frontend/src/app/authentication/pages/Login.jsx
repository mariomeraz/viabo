import { useEffect } from 'react'

import { Box, Stack, Typography } from '@mui/material'
import { useQueryClient } from '@tanstack/react-query'
import { LazyLoadImage } from 'react-lazy-load-image-component'

import { LoginForm } from '../components'

import LoginImage from '@/shared/assets/img/login-image-2x.webp'
import { Page } from '@/shared/components/containers'
import { FullLogo } from '@/shared/components/images'

const Login = () => {
  const client = useQueryClient()

  useEffect(() => {
    client.removeQueries()
  }, [])

  return (
    <Page title="Inicio de Sesión">
      <Stack alignItems={'center'} justifyContent={'center'} minHeight={'100dvH'}>
        <Stack px={{ sm: 10, xl: 20 }} width={1} height={1} direction={'row'}>
          <Stack
            flexGrow={1}
            width={1}
            height={1}
            minHeight={'70vh'}
            maxHeight={'90vH'}
            position={'relative'}
            sx={{ overflowX: 'hidden', overflowY: 'auto' }}
            justifyContent={'space-between'}
          >
            <Stack direction={'row'} spacing={1} alignItems={'center'} px={{ xs: 5, sm: 0 }}>
              <FullLogo sx={{ width: 100 }} />
              <Typography fontWeight={'600'} variant="subtitle1">
                Agilidad en pagos
              </Typography>
            </Stack>
            <Box flexGrow={1} />
            <Stack flex={1} px={{ xs: 0, sm: 5, xl: 15 }}>
              <LoginForm />
            </Stack>
          </Stack>
          <Stack
            width={1}
            justifyContent={'center'}
            height={1}
            flexGrow={1}
            sx={{ display: { xs: 'none', sm: 'none', lg: 'flex' } }}
          >
            <Box
              component={LazyLoadImage}
              placeholderSrc="https://zone-assets-api.vercel.app/assets/img_placeholder.svg"
              wrapperClassName="wrapper"
              effect={'blur'}
              height={1}
              maxHeight={'90vH'}
              sx={{ objectFit: 'fill' }}
              borderRadius={4}
              src={LoginImage}
            />
          </Stack>
        </Stack>
      </Stack>
    </Page>
  )
}

export default Login
