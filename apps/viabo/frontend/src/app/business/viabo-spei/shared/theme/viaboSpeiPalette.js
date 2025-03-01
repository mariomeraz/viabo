import { alpha } from '@mui/material'
import { palette } from '@theme/overrides/options'

const PRIMARY = {
  lighter: '#d6edff',
  light: '#99B9F6',
  main: '#004FE9',
  dark: '#104198',
  darker: '#03194d'
}

const SECONDARY = {
  lighter: '#d6edff',
  light: '#CCD1DC',
  main: '#CDD1E9',
  dark: '#001750',
  darker: '#000'
}

const PRIMARY_DARK = {
  lighter: '#d6edff',
  light: '#b7e1ff',
  main: '#004FE9',
  dark: '#104198',
  darker: '#03194d'
}

const SECONDARY_DARK = {
  lighter: '#d6edff',
  light: '#b7e1ff',
  main: '#fff',
  dark: '#F0EEEF',
  darker: '#CCD1DC'
}

const GREY = {
  0: '#FFFFFF',
  100: '#F9FAFB',
  200: '#F4F6F8',
  300: '#DFE3E8',
  400: '#C4CDD5',
  500: '#919EAB',
  600: '#637381',
  700: '#454F5B',
  800: '#FFFFFF',
  900: '#161C24',
  500_8: alpha('#919EAB', 0.08),
  500_12: alpha('#919EAB', 0.12),
  500_16: alpha('#919EAB', 0.16),
  500_24: alpha('#919EAB', 0.24),
  500_32: alpha('#919EAB', 0.32),
  500_48: alpha('#919EAB', 0.48),
  500_56: alpha('#919EAB', 0.56),
  500_80: alpha('#919EAB', 0.8)
}

export const viaboSpeiPalette = {
  light: {
    ...palette.light,
    primary: { ...PRIMARY, contrastText: '#fff' },
    secondary: { ...SECONDARY, contrastText: '#fff' },
    background: { paper: '#fff', default: '#fff', neutral: '#F2F0F0' }
  },
  dark: {
    ...palette.dark,
    primary: { ...SECONDARY_DARK, contrastText: '#001750' },
    secondary: { ...PRIMARY_DARK, contrastText: '#fff' },
    background: { paper: '#03194d', default: '#001750', neutral: '#4D5D85' },
    text: { primary: '#fff', secondary: '#F2F0F0', disabled: '#fff' }
  }
}
