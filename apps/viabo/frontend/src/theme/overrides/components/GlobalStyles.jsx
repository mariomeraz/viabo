import { GlobalStyles as GlobalThemeStyles } from '@mui/material'
import { alpha, useTheme } from '@mui/material/styles'

export default function GlobalStyles() {
  const theme = useTheme()

  return (
    <GlobalThemeStyles
      styles={{
        '*': {
          margin: 0,
          padding: 0,
          boxSizing: 'border-box',
          '*::-webkit-scrollbar': {
            height: 6,
            width: '0.4em'
          },
          '*::-webkit-scrollbar-track': {
            boxShadow: 'inset 0 0 6px rgba(0,0,0,0.00)'
          },
          '*::-webkit-scrollbar-thumb': {
            borderRadius: '7px',
            backgroundColor: `${alpha(theme.palette.grey[600], 0.48)}`
          }
        },
        html: {
          width: '100%',
          height: '100%'
        },
        body: {
          width: '100%',
          height: '100%',
          background:
            theme.palette.mode === 'dark'
              ? `radial-gradient(125% 125% at 50% 30%,${theme.palette.background.default} 20%,${theme.palette.secondary.main} 120%)`
              : `radial-gradient(ellipse 80% 80% at 60% -20%,${alpha(theme.palette.primary.light, 0.1)},${
                  theme.palette.background.default
                })`
        },
        '#root': {
          width: '100%',
          height: '100%'
        },
        // input: {
        //   '&[type=number]': {
        //     MozAppearance: 'textfield',
        //     '&::-webkit-outer-spin-button': {
        //       margin: 0,
        //       WebkitAppearance: 'none'
        //     },
        //     '&::-webkit-inner-spin-button': {
        //       margin: 0,
        //       WebkitAppearance: 'none'
        //     }
        //   }
        // },
        // textarea: {
        //   '&::-webkit-input-placeholder': {
        //     color: theme.palette.text.disabled
        //   },
        //   '&::-moz-placeholder': {
        //     opacity: 1,
        //     color: theme.palette.text.disabled
        //   },
        //   '&:-ms-input-placeholder': {
        //     color: theme.palette.text.disabled
        //   },
        //   '&::placeholder': {
        //     color: theme.palette.text.disabled
        //   }
        // },

        img: { display: 'block', maxWidth: '100%' },

        // Lazy Load Img
        '.blur-up': {
          WebkitFilter: 'blur(5px)',
          filter: 'blur(5px)',
          transition: 'filter 400ms, -webkit-filter 400ms'
        },
        '.blur-up.lazyloaded ': {
          WebkitFilter: 'blur(0)',
          filter: 'blur(0)'
        }
      }}
    />
  )
}
