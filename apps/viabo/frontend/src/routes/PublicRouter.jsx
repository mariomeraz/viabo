import { lazy } from 'react'

import { PUBLIC_PATHS } from './paths'

import { LoadableRoute } from '@/routes/LoadableRoute'
import { useLightThemeOnMount } from '@/shared/hooks'

const ChargePaymentLink = LoadableRoute(
  lazy(() => import('@/app/business/viabo-pay/terminal-charge-payment-link/pages/ChargePaymentLink'))
)
const CommerceRegister = LoadableRoute(lazy(() => import('@/app/business/commerce/pages/CommerceRegister')))
const RegisterCards = LoadableRoute(lazy(() => import('@/app/business/viabo-card/register-cards/pages/RegisterCards')))
const Privacy = LoadableRoute(lazy(() => import('@/app/public/privacy/pages/Privacy')))
const Policies = LoadableRoute(lazy(() => import('@/app/public/privacy/pages/Policies')))
const PublicPayments = LoadableRoute(lazy(() => import('@/app/public/payments/pages/PublicPayments')))

export const PublicRouter = [
  {
    path: '/cobro/:paymentId',
    Component() {
      useLightThemeOnMount()
      return <ChargePaymentLink />
    }
  },
  {
    path: '/comercio/registro',
    Component() {
      useLightThemeOnMount()
      return <CommerceRegister />
    }
  },
  {
    path: '/registro',
    Component() {
      useLightThemeOnMount()
      return <RegisterCards />
    }
  },
  {
    path: PUBLIC_PATHS.privacy,
    Component: Privacy
  },
  {
    path: PUBLIC_PATHS.policies,
    Component: Policies
  },
  {
    path: PUBLIC_PATHS.payments,
    Component() {
      useLightThemeOnMount()
      return <PublicPayments />
    }
  }
]

export const WHITE_THEME_LIST = ['/comercio/registro', '/registro', '/cobro/*', '/pagos/*']
