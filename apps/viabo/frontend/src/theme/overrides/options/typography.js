import { pxToRem, responsiveFontSizes } from '@theme/utils'

// const FONT_PRIMARY = 'Public Sans, sans-serif' // Google Font
const FONT_PRIMARY = 'Poppins, sans-serif'
// const FONT_SECONDARY = 'CircularStd, sans-serif'; // Local Font

export const typography = {
  fontFamily: FONT_PRIMARY,
  fontWeightRegular: 400,
  fontWeightMedium: 600,
  fontWeightBold: 700,
  h1: {
    fontWeight: 500,
    lineHeight: 1.2,
    fontSize: pxToRem(32),
    letterSpacing: 2,
    ...responsiveFontSizes({ sm: 40, md: 52, lg: 58 })
  },
  h2: {
    fontWeight: 500,
    lineHeight: 1.3,
    fontSize: pxToRem(28),
    ...responsiveFontSizes({ sm: 32, md: 40, lg: 44 })
  },
  h3: {
    fontWeight: 500,
    lineHeight: 1.4,
    fontSize: pxToRem(24),
    ...responsiveFontSizes({ sm: 20, md: 24, lg: 28 })
  },
  h4: {
    fontWeight: 500,
    lineHeight: 1.5,
    fontSize: pxToRem(20),
    ...responsiveFontSizes({ sm: 18, md: 20, lg: 22 })
  },
  h5: {
    fontWeight: 500,
    lineHeight: 1.5,
    fontSize: pxToRem(16),
    ...responsiveFontSizes({ sm: 16, md: 18, lg: 20 })
  },
  h6: {
    fontWeight: 500,
    lineHeight: 1.5,
    fontSize: pxToRem(14),
    ...responsiveFontSizes({ sm: 14, md: 16, lg: 18 })
  },
  subtitle1: {
    fontWeight: 400,
    lineHeight: 1.5,
    fontSize: pxToRem(15),
    ...responsiveFontSizes({ sm: 14, md: 14, lg: 15 })
  },
  subtitle2: {
    fontWeight: 400,
    lineHeight: 1.5,
    fontSize: pxToRem(13),
    ...responsiveFontSizes({ sm: 12, md: 12, lg: 13 })
  },
  body1: {
    lineHeight: 1.5,
    fontSize: pxToRem(15),
    ...responsiveFontSizes({ sm: 14, md: 14, lg: 15 })
  },
  body2: {
    lineHeight: 1.5,
    fontSize: pxToRem(13),
    ...responsiveFontSizes({ sm: 12, md: 12, lg: 13 })
  },
  caption: {
    lineHeight: 1.5,
    fontSize: pxToRem(13),
    ...responsiveFontSizes({ sm: 12, md: 12, lg: 13 })
  },
  overline: {
    fontWeight: 600,
    lineHeight: 1.5,
    fontSize: pxToRem(13),
    ...responsiveFontSizes({ sm: 12, md: 12, lg: 13 }),
    textTransform: 'uppercase'
  },
  button: {
    fontWeight: 600,
    lineHeight: 1.5,
    fontSize: pxToRem(13),
    ...responsiveFontSizes({ sm: 12, md: 12, lg: 13 }),
    textTransform: 'capitalize'
  }
}
