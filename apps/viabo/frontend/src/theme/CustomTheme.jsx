import { useMemo } from 'react'

import PropTypes from 'prop-types'

import { createTheme, CssBaseline, styled, ThemeProvider } from '@mui/material'
import { useSettings } from '@theme/hooks/useSettings'
import { ComponentsOverrides } from '@theme/overrides/components'
import { breakpoints, customShadows, palette, shadows, typography } from '@theme/overrides/options'
import { ToastContainer, Zoom } from 'react-toastify'

import { viaboSpeiPalette } from '@/app/business/viabo-spei/shared/theme'

const StyledToastContainer = styled(ToastContainer)(({ theme }) => ({
  '& .Toastify__toast': {
    background: theme.palette.background.paper,
    color: theme.palette.text.primary,
    borderRadius: theme.shape.borderRadius
  },
  '& .Toastify__close-button': {
    color: theme.palette.text.primary
  }
}))
export const CustomTheme = ({ children }) => {
  const { themeMode, themeDirection, isCentralPayTheme } = useSettings()
  const isLight = themeMode === 'light'

  const customPalette = useMemo(
    () => (isCentralPayTheme ? viaboSpeiPalette : palette),
    [isCentralPayTheme, viaboSpeiPalette, palette]
  )

  const customShadowsByCustomPalette = useMemo(() => customShadows(customPalette), [customPalette])

  const themeOptions = useMemo(
    () => ({
      palette: isLight ? customPalette.light : customPalette.dark,
      typography,
      breakpoints,
      shape: { borderRadius: 8 },
      direction: themeDirection,
      shadows: isLight ? shadows.light : shadows.dark,
      customShadows: isLight ? customShadowsByCustomPalette.light : customShadowsByCustomPalette.dark
    }),
    [isLight, themeDirection, customPalette]
  )

  const theme = createTheme(themeOptions)

  // theme = responsiveFontSizes(theme);

  theme.components = ComponentsOverrides(theme)

  return (
    // <StyledEngineProvider injectFirst>
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <StyledToastContainer
        theme={theme}
        position="top-center"
        transition={Zoom}
        autoClose={3000}
        hideProgressBar={false}
        newestOnTop={true}
        closeOnClick
        rtl={false}
        pauseOnFocusLoss
        draggable
        pauseOnHover
        stacked
      />
      {children}
    </ThemeProvider>
    // </StyledEngineProvider>
  )
}

CustomTheme.propTypes = {
  children: PropTypes.node
}
