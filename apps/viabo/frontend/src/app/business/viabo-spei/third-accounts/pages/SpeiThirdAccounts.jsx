import { lazy } from 'react'

import { useViaboSpeiBreadCrumbs } from '../../shared/hooks'
import { SpeiThirdAccountsList } from '../components/SpeiThirdAccountsList'

import { Page } from '@/shared/components/containers'
import { ContainerPage } from '@/shared/components/containers/ContainerPage'
import { HeaderPage } from '@/shared/components/layout'
import { Lodable } from '@/shared/components/lodables'

const NewSpeiThirdAccountDrawer = Lodable(
  lazy(() => import('../components/new-third-account/NewSpeiThirdAccountDrawer'))
)
const AlertConfirmationDeleteAccount = Lodable(lazy(() => import('../components/AlertConfirmationDeleteAccount')))

export const SpeiThirdAccounts = () => {
  const { thirdAccounts } = useViaboSpeiBreadCrumbs()

  return (
    <Page title="Cuentas de Terceros - Viabo Spei">
      <ContainerPage sx={{ pb: 3 }}>
        <HeaderPage name={'Cuentas de Terceros '} links={thirdAccounts} />
        <SpeiThirdAccountsList />
        <NewSpeiThirdAccountDrawer />
        <AlertConfirmationDeleteAccount />
      </ContainerPage>
    </Page>
  )
}
