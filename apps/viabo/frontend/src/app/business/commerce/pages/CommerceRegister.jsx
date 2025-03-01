import { Box, Grid } from '@mui/material'
import { alpha, styled } from '@mui/material/styles'
import { LazyLoadImage } from 'react-lazy-load-image-component'

import { RegisterProcess } from '@/app/business/commerce/components'
import INTEGRATION from '@/shared/assets/img/integracion-tecnologica.png'
import { Page } from '@/shared/components/containers'

const OverlayStyle = styled('div')(({ theme }) => ({
  top: 0,
  left: 0,
  right: 0,
  bottom: 0,
  zIndex: 8,
  position: 'absolute',
  backgroundColor: alpha(theme.palette.grey[900], 0.1)
}))

function CommerceRegister() {
  return (
    <Page title="Registro Comercio">
      <Grid container spacing={0} component="main" justifyContent={'center'} height={'100vH'}>
        <Grid item elevation={0} xs={false} sm={false} md={6} xl={7}>
          <Box
            sx={{ position: 'relative', display: { xs: 'none', md: 'flex' }, height: 1, backgroundColor: '#161C24' }}
          >
            <OverlayStyle />
            <Box
              component={LazyLoadImage}
              wrapperClassName="wrapper"
              effect={'blur'}
              placeholderSrc="https://zone-assets-api.vercel.app/assets/img_placeholder.svg"
              sx={{ width: 1, height: 1, objectFit: 'cover' }}
              src={INTEGRATION}
            />
          </Box>
        </Grid>
        <Grid item xs={12} sm={12} md={6} xl={5} alignItems="center" justify="center" sx={{ overflow: 'auto' }}>
          <RegisterProcess />
        </Grid>
      </Grid>
    </Page>
  )
}

export default CommerceRegister
